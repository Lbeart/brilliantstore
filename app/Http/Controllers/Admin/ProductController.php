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
        $q = Product::query()->orderByDesc('id');

        if ($s = $request->get('search')) {
            $q->where('name', 'like', "%{$s}%");
        }

        $products = $q->paginate(12);
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
            'sizes'       => 'nullable|array',
            'description' => 'nullable|string',
            'is_active'   => 'sometimes|boolean',

            // ✅ MULTI IMAGE
            'image'       => 'nullable|array',
            'image.*'     => 'file|max:51200',

            'sku'         => 'nullable|alpha_dash|unique:products,sku',
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

        // ❌ MOS E NDRYSHO category në perde-ditore/perde-anesore
        //    category mbetet 'perde', subcategory mban ditore/anesore

        // ✅ SAVE MULTI IMAGES AS JSON IN image_path
        $paths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $paths[] = $this->saveUploadedImage($img); // "products/uuid.jpg"
            }
        }
        $data['image_path'] = !empty($paths) ? json_encode($paths, JSON_UNESCAPED_SLASHES) : null;

        // Normalizo sizes
        $norm = $this->normalizeSizes($request->input('sizes', []));
        $data['sizes'] = !empty($norm) ? json_encode($norm, JSON_UNESCAPED_SLASHES) : null;

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
        $product->sizes = $product->sizes ? json_decode($product->sizes, true) : [];

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
            'sizes'       => 'nullable|array',
            'description' => 'nullable|string',
            'is_active'   => 'sometimes|boolean',

            // ✅ MULTI IMAGE
            'image'       => 'nullable|array',
            'image.*'     => 'file|max:51200',

            // ✅ mbaj/fshi foto ekzistuese
            'existing_images'   => 'nullable|array',
            'existing_images.*' => 'string',

            'sku'         => 'nullable|alpha_dash|unique:products,sku,' . $product->id,
        ], $this->productValidationMessages());

        // ✅ Nëse s’është perde, mos ruaj subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $product->is_active;

        if ($product->name !== $data['name']) {
            $data['slug'] = Product::generateSlug($data['name']);
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
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $keep[] = $this->saveUploadedImage($img);
            }
        }

        $data['image_path'] = !empty($keep) ? json_encode(array_values($keep), JSON_UNESCAPED_SLASHES) : null;
        // =========================================

        // Normalizo sizes
        $norm = $this->normalizeSizes($request->input('sizes', []));
        $data['sizes'] = !empty($norm) ? json_encode($norm, JSON_UNESCAPED_SLASHES) : null;

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

    public function destroy(Product $product)
    {
        $paths = $this->decodeImagePaths($product->image_path);
        foreach ($paths as $p) {
            $this->deleteImagePath($p);
        }

        $product->delete();
        return back()->with('ok', 'Produkti u fshi.');
    }

    // ===== Helpers =====

    private function saveUploadedImage($img): string
    {
        $this->assertSupportedImage($img);

        $extension = $this->normalizedImageExtension($img);

        $path = public_path('images/products');
        $this->ensureDirectory($path);

        if ($this->canOptimizeImages()) {
            $filename = $this->newImageFilename('jpg');
            $dbPath = 'products/' . $filename;
            $relativePath = 'images/' . $dbPath;
            $targetPath = $path . DIRECTORY_SEPARATOR . $filename;

            try {
                Image::make($img->getRealPath())
                    ->orientate()
                    ->resize(1600, 1600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 82)
                    ->save($targetPath);

                $this->writeOptimizedCache($targetPath, $relativePath);

                return $dbPath;
            } catch (\Throwable $e) {
                report($e);

                if (in_array($extension, ['heic', 'heif'], true)) {
                    throw ValidationException::withMessages([
                        'image' => 'Kjo foto eshte HEIC/HEIF dhe serveri nuk po mundet me e kthy ne JPG. Zgjedhe Save as JPEG/Most Compatible ne telefon, ose dergo foto JPG/PNG.',
                    ]);
                }
            }
        }

        if (in_array($extension, ['heic', 'heif'], true)) {
            throw ValidationException::withMessages([
                'image' => 'Kjo foto eshte HEIC/HEIF. Serveri pranon JPG, PNG, WEBP, GIF ose BMP per produktet.',
            ]);
        }

        $filename = $this->newImageFilename($extension);
        $dbPath = 'products/' . $filename;
        try {
            $img->move($path, $filename);
        } catch (\Throwable $e) {
            report($e);

            throw ValidationException::withMessages([
                'image' => 'Fotoja nuk u ruajt ne server. Kontrollo qe public/images/products ka permission per upload.',
            ]);
        }

        $this->writeOptimizedCache($path . DIRECTORY_SEPARATOR . $filename, 'images/' . $dbPath);

        return $dbPath;
    }

    private function assertSupportedImage($img): void
    {
        $extension = $this->normalizedImageExtension($img);
        $mime = strtolower((string) $img->getMimeType());

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
        $extension = strtolower((string) ($img->getClientOriginalExtension() ?: $img->extension() ?: 'jpg'));
        $extension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg';

        return $extension === 'jpeg' ? 'jpg' : $extension;
    }

    private function newImageFilename(string $extension): string
    {
        $extension = $extension === 'jpeg' ? 'jpg' : strtolower($extension);

        do {
            $filename = strtolower(Str::random(18)) . '.' . $extension;
        } while (is_file(public_path('images/products/' . $filename)));

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

    private function productValidationMessages(): array
    {
        return [
            'image.*.file' => 'Fotoja nuk u lexua mire. Provo nje foto JPG, PNG ose WEBP.',
            'image.*.max' => 'Fotoja eshte shume e madhe. Provo nje foto me te vogel ose zgjidh me pak foto njeheresh.',
        ];
    }

    private function normalizeSizes(array $sizes): array
    {
        $out = [];
        if (isset($sizes['label']) && is_array($sizes['label'])) {
            foreach ($sizes['label'] as $i => $lbl) {
                $lbl = trim((string) $lbl);
                if ($lbl === '') continue;

                $price = isset($sizes['price'][$i]) && $sizes['price'][$i] !== '' ? (float) $sizes['price'][$i] : null;
                $stock = isset($sizes['stock'][$i]) && $sizes['stock'][$i] !== '' ? (int) $sizes['stock'][$i] : 0;

                $out[] = ['label' => $lbl, 'price' => $price, 'stock' => $stock];
            }
        }
        return $out;
    }
}
