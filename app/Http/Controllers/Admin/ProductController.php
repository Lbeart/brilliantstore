<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

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
            'image.*'     => 'image|max:10240',

            'sku'         => 'nullable|alpha_dash|unique:products,sku',
        ]);

        // ✅ Nëse s’është perde, mos ruaj subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);

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

        Product::create($data);
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
            'image.*'     => 'image|max:10240',

            // ✅ mbaj/fshi foto ekzistuese
            'existing_images'   => 'nullable|array',
            'existing_images.*' => 'string',

            'sku'         => 'nullable|alpha_dash|unique:products,sku,' . $product->id,
        ]);

        // ✅ Nëse s’është perde, mos ruaj subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');

        if ($product->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);
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
            if ($p) Storage::disk('public')->delete($p);
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

        $product->update($data);
        return redirect()->route('admin.products.index')->with('ok', 'Produkti u përditësua.');
    }

    public function destroy(Product $product)
    {
        $paths = $this->decodeImagePaths($product->image_path);
        foreach ($paths as $p) {
            if ($p) Storage::disk('public')->delete($p);
        }

        $product->delete();
        return back()->with('ok', 'Produkti u fshi.');
    }

    // ===== Helpers =====

    private function saveUploadedImage($img): string
    {
        $filename = (string) Str::uuid() . '.jpg';

        $image = Image::make($img)
            ->orientate()
            ->resize(800, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

        Storage::disk('public')->put("products/$filename", (string) $image->encode('jpg', 70));
        return "products/$filename";
    }

    private function decodeImagePaths($value): array
    {
        if (empty($value)) return [];

        if (is_array($value)) return array_values(array_filter($value));

        $raw = trim((string) $value);

        // nëse është URL që përmban JSON: .../storage/[...]
        if (preg_match('/\[[^\]]+\]/', $raw, $m)) {
            $raw = $m[0];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        return [$raw];
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
