<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            'subcategory' => 'nullable|string|in:anesore,ditore',
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

        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(6);

        if (empty($data['sku'])) {
            $data['sku'] = Str::upper(Str::slug($data['name'])).'-'.Str::random(4);
        }

        // ✅ SAVE MULTI IMAGES AS JSON IN image_path
        $paths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $ext = strtolower($img->getClientOriginalExtension());
               $filename = Str::uuid().'.jpg';

$image = Image::make($img)
  ->orientate()
  ->resize(800, null, function ($c) {
      $c->aspectRatio();
      $c->upsize();
  });

Storage::disk('public')->put("products/$filename", (string) $image->encode('jpg', 70));
$paths[] = "products/$filename";
            }
        }

        $data['image_path'] = !empty($paths) ? json_encode($paths) : null;

        // Normalizo sizes
        $norm = $this->normalizeSizes($request->input('sizes', []));
        $data['sizes'] = !empty($norm) ? json_encode($norm) : null;

        // Derivo price/stock nga sizes
        if (!empty($norm)) {
            $minPrice = collect($norm)->pluck('price')->filter(fn($p) => $p !== null)->min();
            $sumStock = collect($norm)->pluck('stock')->sum();
            $data['price'] = $minPrice ?? ($data['price'] ?? 0);
            $data['stock'] = $sumStock ?? ($data['stock'] ?? 0);
        }
        if (($data['category'] ?? null) === 'perde' && !empty($data['subcategory'])) {
    $data['category'] = 'perde-' . $data['subcategory']; // perde-ditore / perde-anesore
}

        Product::create($data);

        return redirect()->route('admin.products.index')->with('ok', 'Produkti u shtua.');
    }

    public function edit(Product $product)
    {
        $product->sizes = $product->sizes ? json_decode($product->sizes, true) : [];
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string|max:50',
            'subcategory' => 'nullable|string|in:anesore,ditore',
            'price'       => 'nullable|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'sizes'       => 'nullable|array',
            'description' => 'nullable|string',
            'is_active'   => 'sometimes|boolean',

            // ✅ MULTI IMAGE
            'image'       => 'nullable|array',
            'image.*'     => 'image|max:10240',

            'sku'         => 'nullable|alpha_dash|unique:products,sku,'.$product->id,
        ]);

        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');

        if ($product->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::random(6);
        }

        // ✅ KEEP OLD IMAGES + ADD NEW ONES
        $existing = [];
        if ($product->image_path) {
            $decoded = json_decode($product->image_path, true);
            $existing = is_array($decoded) ? $decoded : [$product->image_path];
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $ext = strtolower($img->getClientOriginalExtension());
                $filename = Str::uuid().'.'.($ext === 'jpeg' ? 'jpg' : $ext);

                $image = Image::make($img)
                    ->orientate()
                    ->resize(800, null, function ($c) {
                        $c->aspectRatio();
                        $c->upsize();
                    });

                Storage::disk('public')->put("products/$filename", (string)$image->encode('jpg', 70));
                $existing[] = "products/$filename";
            }
        }

        // ✅ only set if we have something
        $data['image_path'] = !empty($existing) ? json_encode($existing) : null;

        // Normalizo sizes
        $norm = $this->normalizeSizes($request->input('sizes', []));
        $data['sizes'] = !empty($norm) ? json_encode($norm) : null;

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
        if ($product->image_path) {
            $decoded = json_decode($product->image_path, true);
            $paths = is_array($decoded) ? $decoded : [$product->image_path];

            foreach ($paths as $p) {
                if ($p) Storage::disk('public')->delete($p);
            }
        }

        $product->delete();
        return back()->with('ok', 'Produkti u fshi.');
    }

    private function normalizeSizes(array $sizes): array
    {
        $out = [];
        if (isset($sizes['label']) && is_array($sizes['label'])) {
            foreach ($sizes['label'] as $i => $lbl) {
                $lbl = trim((string)$lbl);
                if ($lbl === '') continue;

                $price = isset($sizes['price'][$i]) && $sizes['price'][$i] !== '' ? (float)$sizes['price'][$i] : null;
                $stock = isset($sizes['stock'][$i]) && $sizes['stock'][$i] !== '' ? (int)$sizes['stock'][$i] : 0;

                $out[] = ['label' => $lbl, 'price' => $price, 'stock' => $stock];
            }
        }
        return $out;
    }
}
