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
            'image'       => 'nullable|image|max:10240',
            'sku'         => 'nullable|alpha_dash|unique:products,sku',
        ]);

        // Vetëm perde ka subcategory
        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(6);

        if (empty($data['sku'])) {
            $data['sku'] = Str::upper(Str::slug($data['name'])).'-'.Str::random(4);
        }

        // Ruaj imazhin dhe optimizoje
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = strtolower($img->getClientOriginalExtension());
            $filename = Str::uuid().'.'.($ext === 'jpeg' ? 'jpg' : $ext);

            $image = Image::make($img)
                ->orientate()
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            $encoded = in_array($ext, ['png'])
                ? (string) $image->encode('png', 60)
                : (string) $image->encode('jpg', 60);

           Storage::disk('public')->put("products/$filename", (string) $image->encode('jpg', 60));
            $data['image_path'] = "products/$filename";
        }

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
            'image'       => 'nullable|image|max:10240',
            'sku'         => 'nullable|alpha_dash|unique:products,sku,'.$product->id,
        ]);

        if (($data['category'] ?? null) !== 'perde') {
            $data['subcategory'] = null;
        }

        $data['is_active'] = $request->boolean('is_active');

        if ($product->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::random(6);
        }

        // Ruaj imazhin dhe optimizoje
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $img = $request->file('image');
            $ext = strtolower($img->getClientOriginalExtension());
            $filename = Str::uuid().'.'.($ext === 'jpeg' ? 'jpg' : $ext);

            $image = Image::make($img)
                ->orientate()
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            $encoded = in_array($ext, ['png'])
                ? (string) $image->encode('png', 80)
                : (string) $image->encode('jpg', 80);

            Storage::disk('public')->put("products/$filename", $encoded);
            $data['image_path'] = "products/$filename";
        }

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
            Storage::disk('public')->delete($product->image_path);
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
