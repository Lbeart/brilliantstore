<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Support\ProductImages;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query();

        $search = trim((string) $request->get('search', ''));
        if ($search !== '') {
            $q->where(function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where('name', 'like', $like)
                    ->orWhere('slug', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhere('barcode', 'like', $like);
            });
        }

        if (in_array($request->get('active'), ['0', '1'], true)) {
            $q->where('is_active', (bool) $request->integer('active'));
        }

        match ($request->get('sort', 'newest')) {
            'oldest' => $q->oldest('id'),
            'price_hi' => $q->orderByDesc('price'),
            'price_lo' => $q->orderBy('price'),
            'name_az' => $q->orderBy('name'),
            'name_za' => $q->orderByDesc('name'),
            default => $q->orderByDesc('id'),
        };

        $perPage = min(max((int) $request->get('per_page', 12), 6), 100);
        $products = $q->paginate($perPage)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:50',

            // ✅ subcategory REQUIRED vetëm kur category = perde
            'subcategory' => [
                'nullable',
                'string',
                Rule::in(['anesore', 'ditore']),
                Rule::requiredIf(fn () => $request->input('category') === 'perde'),
            ],

            'price'       => 'nullable|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'cover_meter_price' => 'nullable|numeric|min:0',
            'sizes'       => 'nullable|array',
            'description' => 'nullable|string',
            'is_active'   => 'sometimes|boolean',

            // ✅ MULTI IMAGE
            'image'       => 'nullable|array',
            'image.*'     => 'file|max:40960',

            'color_variants' => 'nullable|array',
            'color_variants.name' => 'nullable|array',
            'color_variants.name.*' => 'nullable|string|max:80',
            'color_variants.hex' => 'nullable|array',
            'color_variants.hex.*' => ['nullable', 'string', 'max:20', 'regex:/^#?[A-Fa-f0-9]{3,8}$/'],
            'color_variant_images' => 'nullable|array',
            'color_variant_images.*' => 'nullable|array',
            'color_variant_images.*.*' => 'nullable|file|max:40960',

            'sku'         => 'nullable|alpha_dash|unique:products,sku',
            'barcode'     => ['nullable', 'string', 'max:80', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:products,barcode'],
        ], $this->productValidationMessages());

        // ✅ Nëse s’është perde, mos ruaj subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        // Slug generated automatically in model

        if (empty($data['sku'])) {
            $data['sku'] = Str::upper(Str::slug($data['name'])) . '-' . Str::random(4);
        }

        if (empty($data['barcode'])) {
            $data['barcode'] = Product::generateBarcode();
        }

        // ❌ MOS E NDRYSHO category në perde-ditore/perde-anesore
        //    category mbetet 'perde', subcategory mban ditore/anesore

        // ✅ SAVE MULTI IMAGES AS JSON IN image_path
        $paths = [];
        try {
            foreach ($this->uploadedImageFiles($request) as $img) {
                $paths[] = $this->saveUploadedImage($img);
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Fotoja nuk u pranua nga serveri. Provo JPG/PNG/WEBP me madhesi me te vogel, ose vetem nje foto.'])
                ->withInput();
        }
        $data['image_path'] = !empty($paths) ? json_encode($paths, JSON_UNESCAPED_SLASHES) : null;

        try {
            $data['color_variants'] = $this->normalizeColorVariants($request);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['color_variants' => 'Ngjyrat nuk u ruajten. Provo foto JPG/PNG/WEBP me madhesi me te vogel.'])
                ->withInput();
        }

        // Normalizo sizes
        $rawSizes = $this->mergeCoverMeterPrice(
            $request->input('sizes', []),
            $request,
            $data['category'] ?? null,
            isset($data['stock']) ? (int) $data['stock'] : 0
        );
        $norm = $this->normalizeSizes($rawSizes, $data['barcode']);
        $data['sizes'] = !empty($norm) ? $norm : null;

        // Derivo price/stock nga sizes
        if (!empty($norm)) {
            $minPrice = collect($norm)->pluck('price')->filter(fn($p) => $p !== null)->min();
            $sumStock = collect($norm)->pluck('stock')->sum();
            $data['price'] = $minPrice ?? ($data['price'] ?? 0);
            $data['stock'] = $sumStock ?? ($data['stock'] ?? 0);
        }

        try {
            Product::create($data);
        } catch (QueryException $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Produkti nuk u ruajt ne databaze. Nese ke vendos disa foto, provo vetem nje foto; pastaj duhet me u ekzekutu migrimi qe e zgjeron image_path.'])
                ->withInput();
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Serveri nuk e ruajti produktin. Provo nje foto JPG/PNG me te vogel ose nje foto te vetme.'])
                ->withInput();
        }

        return redirect()->route('admin.products.index')->with('ok', 'Produkti u shtua.');
    }

    public function edit(Product $product)
    {
        $sizes = $product->sizes;
        if (is_string($sizes)) {
            $decoded = json_decode($sizes, true);
            $sizes = is_array($decoded) ? $decoded : [];
        }
        $product->sizes = is_array($sizes) ? $sizes : [];

        // ✅ images array për view
        $product->images = $this->decodeImagePaths($product->image_path);

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:50',

            // ✅ subcategory REQUIRED vetëm kur category = perde
            'subcategory' => [
                'nullable',
                'string',
                Rule::in(['anesore', 'ditore']),
                Rule::requiredIf(fn () => $request->input('category') === 'perde'),
            ],

            'price'       => 'nullable|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'cover_meter_price' => 'nullable|numeric|min:0',
            'sizes'       => 'nullable|array',
            'description' => 'nullable|string',
            'is_active'   => 'sometimes|boolean',

            // ✅ MULTI IMAGE
            'image'       => 'nullable|array',
            'image.*'     => 'file|max:40960',

            // ✅ mbaj/fshi foto ekzistuese
            'color_variants' => 'nullable|array',
            'color_variants.name' => 'nullable|array',
            'color_variants.name.*' => 'nullable|string|max:80',
            'color_variants.hex' => 'nullable|array',
            'color_variants.hex.*' => ['nullable', 'string', 'max:20', 'regex:/^#?[A-Fa-f0-9]{3,8}$/'],
            'color_variants.existing_image' => 'nullable|array',
            'color_variants.existing_image.*' => 'nullable|string',
            'color_variants.existing_images' => 'nullable|array',
            'color_variants.existing_images.*' => 'nullable|array',
            'color_variants.existing_images.*.*' => 'nullable|string',
            'color_variant_images' => 'nullable|array',
            'color_variant_images.*' => 'nullable|array',
            'color_variant_images.*.*' => 'nullable|file|max:40960',

            'existing_images'   => 'nullable|array',
            'existing_images.*' => 'string',

            'sku'         => 'nullable|alpha_dash|unique:products,sku,' . $product->id,
            'barcode'     => ['nullable', 'string', 'max:80', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:products,barcode,' . $product->id],
        ], $this->productValidationMessages());

        // ✅ Nëse s’është perde, mos ruaj subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $product->is_active;

        if ($product->name !== $data['name']) {
            $data['slug'] = Product::generateSlug($data['name']);
        }

        if (empty($data['barcode'])) {
            $data['barcode'] = Product::generateBarcode();
        }

        // ❌ MOS E NDRYSHO category në perde-ditore/perde-anesore
        //    category mbetet 'perde', subcategory mban ditore/anesore

        // ====== ✅ IMAGE REPLACE/REMOVE LOGIC ======
        $old  = $this->decodeImagePaths($product->image_path); // fotot në DB
        $keep = $request->input('existing_images', []);        // fotot që user i la në form

        // siguri: mbaj vetëm ato që ekzistojnë në $old
        $keep = is_array($keep) ? array_values(array_intersect($old, $keep)) : [];

        // fshi nga disk ato që u hoqën
        $toDelete = array_values(array_diff($old, $keep));
        foreach ($toDelete as $p) {
            $this->deleteImagePath($p);
        }

        // shto fotot e reja
        try {
            foreach ($this->uploadedImageFiles($request) as $img) {
                $keep[] = $this->saveUploadedImage($img);
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Fotoja nuk u pranua nga serveri. Provo JPG/PNG/WEBP me madhesi me te vogel, ose vetem nje foto.'])
                ->withInput();
        }

        $data['image_path'] = !empty($keep) ? json_encode(array_values($keep), JSON_UNESCAPED_SLASHES) : null;
        // =========================================

        try {
            $data['color_variants'] = $this->normalizeColorVariants($request, $product);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['color_variants' => 'Ngjyrat nuk u perditesuan. Provo foto JPG/PNG/WEBP me madhesi me te vogel.'])
                ->withInput();
        }

        // Normalizo sizes
        $rawSizes = $this->mergeCoverMeterPrice(
            $request->input('sizes', []),
            $request,
            $data['category'] ?? null,
            isset($data['stock']) ? (int) $data['stock'] : (int) $product->stock
        );
        $norm = $this->normalizeSizes($rawSizes, $data['barcode']);
        $data['sizes'] = !empty($norm) ? $norm : null;

        if (!empty($norm)) {
            $minPrice = collect($norm)->pluck('price')->filter(fn($p) => $p !== null)->min();
            $sumStock = collect($norm)->pluck('stock')->sum();
            $data['price'] = $minPrice ?? ($data['price'] ?? $product->price);
            $data['stock'] = $sumStock ?? ($data['stock'] ?? $product->stock);
        }

        try {
            $product->update($data);
        } catch (QueryException $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Produkti nuk u perditesua ne databaze. Provo me nje foto me pak ose ekzekuto migrimet e fundit.'])
                ->withInput();
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['image' => 'Serveri nuk e perditesoi produktin. Provo nje foto JPG/PNG me te vogel ose nje foto te vetme.'])
                ->withInput();
        }

        return redirect()->route('admin.products.index')->with('ok', 'Produkti u përditësua.');
    }

    public function barcode(Request $request, Product $product)
    {
        $product = $this->ensureSizeBarcodes($product);
        $copies = min(max((int) $request->query('copies', 1), 1), 100);

        return view('admin.products.barcode', compact('product', 'copies'));
    }

    public function destroy(Product $product)
    {
        $paths = $this->decodeImagePaths($product->image_path);
        foreach ($paths as $p) {
            $this->deleteImagePath($p);
        }

        foreach ($this->decodeColorVariants($product->color_variants) as $variant) {
            $this->deleteImagePath($variant['image_path'] ?? null);
            foreach ($this->decodeImagePaths($variant['image_paths'] ?? null) as $variantImage) {
                $this->deleteImagePath($variantImage);
            }
        }

        $product->delete();
        return back()->with('ok', 'Produkti u fshi.');
    }

    // ===== Helpers =====

    private function uploadedImageFiles(Request $request): array
    {
        $files = $request->file('image', []);

        if ($files instanceof \Illuminate\Http\UploadedFile) {
            $files = [$files];
        }

        if (!is_array($files)) {
            return [];
        }

        $files = array_values(array_filter($files));

        foreach ($files as $file) {
            if (!is_object($file) || !method_exists($file, 'isValid')) {
                continue;
            }

            if (!$file->isValid()) {
                throw ValidationException::withMessages([
                    'image' => $this->uploadErrorMessage((int) $file->getError()),
                ]);
            }
        }

        return $files;
    }

    private function saveUploadedImage($img): string
    {
        $this->assertSupportedImage($img);

        $extension = $this->normalizedImageExtension($img);
        if (in_array($extension, ['heic', 'heif'], true)) {
            throw ValidationException::withMessages([
                'image' => 'Kjo foto eshte HEIC/HEIF. Serveri pranon JPG, PNG, WEBP, GIF ose BMP per produktet.',
            ]);
        }

        $filename = $this->newImageFilename($extension);
        $dbPath = 'products/' . $filename;
        $path = public_path('images/products');

        try {
            $this->ensureDirectory($path);
            $img->move($path, $filename);
            $this->writeOptimizedCache($path . DIRECTORY_SEPARATOR . $filename, 'images/' . $dbPath);

            return $dbPath;
        } catch (\Throwable $e) {
            $this->safeReport($e);
        }

        try {
            Storage::disk('public')->putFileAs('products', $img, $filename);

            return $dbPath;
        } catch (\Throwable $e) {
            $this->safeReport($e);
        }

        throw ValidationException::withMessages([
            'image' => 'Fotoja nuk u ruajt ne server. Kontrollo permission per public/images/products ose storage/app/public/products.',
        ]);
    }

    private function safeReport(\Throwable $e): void
    {
        try {
            report($e);
        } catch (\Throwable) {
            //
        }
    }

    private function assertSupportedImage($img): void
    {
        $extension = $this->normalizedImageExtension($img);

        if (method_exists($img, 'isValid') && !$img->isValid()) {
            throw ValidationException::withMessages([
                'image' => $this->uploadErrorMessage((int) $img->getError()),
            ]);
        }

        try {
            $mime = strtolower((string) $img->getMimeType());
        } catch (\Throwable $e) {
            report($e);
            $mime = '';
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'bmp', 'gif', 'heic', 'heif'];
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/bmp',
            'image/x-ms-bmp',
            'image/gif',
            'image/heic',
            'image/heif',
            'image/heic-sequence',
            'image/heif-sequence',
        ];

        if (!in_array($extension, $allowedExtensions, true) && !in_array($mime, $allowedMimes, true)) {
            throw ValidationException::withMessages([
                'image' => 'Fotoja duhet te jete JPG, PNG, WEBP, GIF ose BMP. HEIC pranohet vetem nese mund te kthehet ne JPG.',
            ]);
        }
    }

    private function normalizedImageExtension($img): string
    {
        $extension = strtolower((string) $img->getClientOriginalExtension());

        if ($extension === '') {
            try {
                $extension = strtolower((string) $img->extension());
            } catch (\Throwable $e) {
                report($e);
                $extension = 'jpg';
            }
        }

        $extension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg';

        return $extension === 'jpeg' ? 'jpg' : $extension;
    }

    private function newImageFilename(string $extension): string
    {
        $extension = $extension === 'jpeg' ? 'jpg' : strtolower($extension);

        do {
            $filename = strtolower(Str::random(18)) . '.' . $extension;
        } while (
            is_file(public_path('images/products/' . $filename))
            || Storage::disk('public')->exists('products/' . $filename)
        );

        return $filename;
    }

    private function writeOptimizedCache(string $sourcePath, string $publicRelativePath): void
    {
        if (!$this->canOptimizeImages() || !is_file($sourcePath)) {
            return;
        }

        $cachePath = public_path(
            'optimized-cache/' . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($publicRelativePath, '/')) . '.jpg'
        );

        $this->ensureDirectory(dirname($cachePath));

        try {
            Image::make($sourcePath)
                ->orientate()
                ->resize(1100, 1100, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 76)
                ->save($cachePath);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function canOptimizeImages(): bool
    {
        return extension_loaded('gd') || extension_loaded('imagick');
    }

    private function ensureDirectory(string $path): void
    {
        if (!is_dir($path) && !mkdir($path, 0775, true) && !is_dir($path)) {
            throw ValidationException::withMessages([
                'image' => 'Serveri nuk mundi me kriju folderin per foto: public/images/products.',
            ]);
        }

        if (!is_writable($path)) {
            throw ValidationException::withMessages([
                'image' => 'Folderi public/images/products nuk ka permission per upload.',
            ]);
        }
    }

    private function deleteImagePath(?string $raw): void
    {
        if (!$raw) {
            return;
        }

        $path = trim((string) $raw, " \t\n\r\0\x0B\"'");

        if (preg_match('#^https?://#i', $path)) {
            $path = parse_url($path, PHP_URL_PATH) ?: $path;
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));
        $path = preg_replace('#^(public|storage)/#', '', $path);

        if ($path === '') {
            return;
        }

        if (str_starts_with($path, 'images/')) {
            $publicPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, $path));
            if (is_file($publicPath)) {
                @unlink($publicPath);
            }

            $this->deleteOptimizedImagePath($path);
            Storage::disk('public')->delete(substr($path, strlen('images/')));
            return;
        }

        Storage::disk('public')->delete($path);

        if (str_starts_with($path, 'products/')) {
            $publicPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, 'images/'.$path));
            if (is_file($publicPath)) {
                @unlink($publicPath);
            }

            $this->deleteOptimizedImagePath('images/'.$path);
        }
    }

    private function deleteOptimizedImagePath(string $publicRelativePath): void
    {
        $path = ltrim(str_replace('\\', '/', $publicRelativePath), '/');

        foreach ([
            'optimized-cache/'.$path,
            'optimized-cache/'.$path.'.jpg',
        ] as $candidate) {
            $fullPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, $candidate));
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }
        }
    }

    private function decodeImagePaths($value): array
    {
        return ProductImages::decode($value);
    }

    private function decodeColorVariants($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return array_values(array_filter($value, fn ($variant) => is_array($variant)));
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? array_values(array_filter($decoded, fn ($variant) => is_array($variant))) : [];
    }

    private function normalizeColorVariants(Request $request, ?Product $product = null): array
    {
        $input = $request->input('color_variants', []);
        $names = $input['name'] ?? [];
        $hexes = $input['hex'] ?? [];
        $existingImages = $input['existing_images'] ?? [];
        $legacyExistingImages = $input['existing_image'] ?? [];
        $files = $request->file('color_variant_images', []);

        if ($files instanceof \Illuminate\Http\UploadedFile) {
            $files = [[$files]];
        }

        $oldImages = [];
        foreach ($this->decodeColorVariants($product?->color_variants) as $variant) {
            foreach ($this->decodeImagePaths($variant['image_paths'] ?? null) as $imagePath) {
                $oldImages[] = $imagePath;
            }

            if (!empty($variant['image_path'])) {
                $oldImages[] = $variant['image_path'];
            }
        }
        $oldImages = array_values(array_unique(array_filter($oldImages)));

        $variants = [];
        $keptImages = [];
        $rowCount = max(
            count($names),
            count($hexes),
            count($existingImages),
            count($legacyExistingImages),
            is_array($files) ? count($files) : 0
        );

        for ($index = 0; $index < $rowCount; $index++) {
            $name = trim((string) ($names[$index] ?? ''));
            $hex = $this->normalizeHexColor((string) ($hexes[$index] ?? ''));
            $imagePaths = [];

            $rowExistingImages = $existingImages[$index] ?? [];
            if (!is_array($rowExistingImages)) {
                $rowExistingImages = [$rowExistingImages];
            }

            foreach ($rowExistingImages as $existingImage) {
                $existingImage = trim((string) $existingImage);
                if ($existingImage !== '') {
                    $imagePaths[] = $existingImage;
                }
            }

            $legacyImage = trim((string) ($legacyExistingImages[$index] ?? ''));
            if ($legacyImage !== '') {
                $imagePaths[] = $legacyImage;
            }

            $rowFiles = is_array($files) ? ($files[$index] ?? []) : [];
            if ($rowFiles instanceof \Illuminate\Http\UploadedFile) {
                $rowFiles = [$rowFiles];
            }
            if (!is_array($rowFiles)) {
                $rowFiles = [];
            }

            foreach ($rowFiles as $file) {
                if (!is_object($file) || !method_exists($file, 'isValid')) {
                    continue;
                }

                if (!$file->isValid()) {
                    throw ValidationException::withMessages([
                        'color_variant_images' => $this->uploadErrorMessage((int) $file->getError()),
                    ]);
                }

                $imagePaths[] = $this->saveUploadedImage($file);
            }

            $imagePaths = array_values(array_unique(array_filter($imagePaths)));

            if ($name === '' && empty($imagePaths)) {
                continue;
            }

            if ($name === '') {
                $name = 'Ngjyra';
            }

            $variant = [
                'name' => $name,
                'hex' => $hex ?: '#d1d5db',
                'image_path' => $imagePaths[0] ?? null,
                'image_paths' => $imagePaths,
            ];

            $variants[] = $variant;

            $keptImages = array_merge($keptImages, $imagePaths);
        }

        foreach (array_diff($oldImages, array_values(array_unique($keptImages))) as $removedImage) {
            $this->deleteImagePath($removedImage);
        }

        return $variants;
    }

    private function normalizeHexColor(string $value): ?string
    {
        $hex = trim($value);
        if ($hex === '') {
            return null;
        }

        $hex = ltrim($hex, '#');

        return preg_match('/^[A-Fa-f0-9]{3,8}$/', $hex) ? '#'.$hex : null;
    }

    private function productValidationMessages(): array
    {
        return [
            'image.*.file' => 'Fotoja nuk u lexua mire. Provo nje foto JPG, PNG ose WEBP.',
            'image.*.max' => 'Fotoja eshte shume e madhe. Provo nje foto me te vogel ose zgjidh me pak foto njeheresh.',
        ];
    }

    private function uploadErrorMessage(int $error): string
    {
        return match ($error) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Fotoja eshte shume e madhe per serverin. Provo nje foto JPG/PNG/WEBP me te vogel.',
            UPLOAD_ERR_PARTIAL => 'Fotoja nuk u ngarkua komplet. Provo prape me internet me stabil ose foto me te vogel.',
            UPLOAD_ERR_NO_TMP_DIR => 'Serverit i mungon folderi i perkohshem per upload. Duhet rregullu konfigurimi i PHP.',
            UPLOAD_ERR_CANT_WRITE => 'Serveri nuk mundi me shkru foton ne disk. Kontrollo permission te hostingut.',
            UPLOAD_ERR_EXTENSION => 'PHP e ndali upload-in e fotos. Provo JPG/PNG/WEBP me te vogel.',
            default => 'Fotoja nuk u pranua nga serveri. Provo JPG/PNG/WEBP me te vogel.',
        };
    }

    private function mergeCoverMeterPrice(array $sizes, Request $request, ?string $category, int $stock): array
    {
        if (($category ?? '') !== 'mbulesa') {
            return $sizes;
        }

        $labels = $sizes['label'] ?? [];
        $prices = $sizes['price'] ?? [];
        $stocks = $sizes['stock'] ?? [];
        $barcodes = $sizes['barcode'] ?? [];

        $filtered = [
            'label' => [],
            'price' => [],
            'stock' => [],
            'barcode' => [],
        ];

        foreach ($labels as $index => $label) {
            if ($this->isCoverMeterLabel((string) $label)) {
                continue;
            }

            $filtered['label'][] = $label;
            $filtered['price'][] = $prices[$index] ?? null;
            $filtered['stock'][] = $stocks[$index] ?? null;
            $filtered['barcode'][] = $barcodes[$index] ?? null;
        }

        if ($request->filled('cover_meter_price')) {
            array_unshift($filtered['label'], 'meter');
            array_unshift($filtered['price'], $request->input('cover_meter_price'));
            array_unshift($filtered['stock'], $stock);
            array_unshift($filtered['barcode'], null);
        }

        return $filtered;
    }

    private function isCoverMeterLabel(string $label): bool
    {
        $normalized = strtolower(preg_replace('/[\s\-_]+/', '', trim($label)) ?? '');

        return in_array($normalized, ['meter', 'metra', 'meteri', 'memeter', 'm'], true);
    }

    private function normalizeSizes(array $sizes, ?string $baseBarcode = null): array
    {
        $out = [];
        if (isset($sizes['label']) && is_array($sizes['label'])) {
            foreach ($sizes['label'] as $i => $lbl) {
                $lbl = trim((string) $lbl);
                if ($lbl === '') continue;

                $price = isset($sizes['price'][$i]) && $sizes['price'][$i] !== '' ? (float) $sizes['price'][$i] : null;
                $stock = isset($sizes['stock'][$i]) && $sizes['stock'][$i] !== '' ? (int) $sizes['stock'][$i] : 0;
                $barcode = trim((string) ($sizes['barcode'][$i] ?? ''));
                if ($barcode === '') {
                    $barcode = $this->makeSizeBarcode($baseBarcode ?: Product::generateBarcode(), $lbl, $i);
                }

                $out[] = ['label' => $lbl, 'price' => $price, 'stock' => $stock, 'barcode' => $barcode];
            }
        }
        return $out;
    }

    private function ensureSizeBarcodes(Product $product): Product
    {
        $sizes = $product->sizes;
        if (is_string($sizes)) {
            $decoded = json_decode($sizes, true);
            $sizes = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($sizes) || empty($sizes)) {
            return $product;
        }

        $changed = false;
        foreach ($sizes as $index => &$size) {
            if (!is_array($size) || empty($size['label'])) {
                continue;
            }

            if (empty($size['barcode'])) {
                $size['barcode'] = $this->makeSizeBarcode($product->barcode ?: $product->sku ?: Product::generateBarcode(), (string) $size['label'], $index);
                $changed = true;
            }
        }
        unset($size);

        if ($changed) {
            $product->sizes = $sizes;
            $product->save();
            $product->refresh();
        }

        return $product;
    }

    private function makeSizeBarcode(string $baseBarcode, string $label, int $index): string
    {
        $base = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $baseBarcode)) ?: 'BRL';
        $size = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $label));
        $barcode = $base.'-S'.($index + 1).($size !== '' ? '-'.$size : '');

        return substr($barcode, 0, 80);
    }
}
