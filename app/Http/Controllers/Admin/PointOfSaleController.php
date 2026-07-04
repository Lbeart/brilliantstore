<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPurchase;
use App\Models\CustomerReceipt;
use App\Models\Product;
use App\Support\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PointOfSaleController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->tablesReady()) {
            return view('admin.customers.setup');
        }

        $today = now()->toDateString();

        $receipts = CustomerReceipt::query()
            ->with(['customer', 'purchases'])
            ->whereDate('sold_at', $today)
            ->latest('sold_at')
            ->latest()
            ->limit(12)
            ->get();

        $summaryQuery = CustomerReceipt::query()->whereDate('sold_at', $today);
        $summary = [
            'receipts_count' => (clone $summaryQuery)->count(),
            'total' => (clone $summaryQuery)->sum('total'),
            'paid' => (clone $summaryQuery)->sum('paid_amount'),
            'balance' => (clone $summaryQuery)->sum('balance'),
            'regular_count' => (clone $summaryQuery)->where('receipt_type', 'regular')->count(),
            'non_regular_count' => (clone $summaryQuery)->where('receipt_type', 'non_regular')->count(),
        ];

        $quickProducts = Product::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(24)
            ->get(['id', 'name', 'price', 'stock', 'sku', 'barcode', 'sizes', 'image_path', 'category', 'subcategory']);

        return view('admin.pos.index', compact('receipts', 'summary', 'quickProducts'));
    }

    public function lookup(Request $request)
    {
        $data = $request->validate([
            'q' => 'required|string|max:120',
        ]);

        $term = trim($data['q']);

        $product = Product::query()
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('barcode', $term)
                    ->orWhere('sku', $term)
                    ->orWhere('id', ctype_digit($term) ? (int) $term : 0)
                    ->orWhere('name', 'like', "%{$term}%");
            })
            ->orderByRaw('CASE WHEN barcode = ? THEN 0 WHEN sku = ? THEN 1 ELSE 2 END', [$term, $term])
            ->first();
        $selectedSize = null;

        if (!$product) {
            $product = Product::query()
                ->where('is_active', true)
                ->where('sizes', 'like', "%{$term}%")
                ->get()
                ->first(function (Product $candidate) use ($term, &$selectedSize) {
                    foreach ($this->decodeProductSizes($candidate->sizes) as $size) {
                        if (($size['barcode'] ?? null) === $term) {
                            $selectedSize = $size;

                            return true;
                        }
                    }

                    return false;
                });
        }

        if (!$product) {
            return response()->json([
                'message' => 'Produkti nuk u gjet me kete barkod/SKU.',
            ], 404);
        }

        return response()->json([
            'product' => $this->productPayload($product, $selectedSize),
        ]);
    }

    public function checkout(Request $request)
    {
        if (!$this->tablesReady()) {
            return redirect()->route('admin.pos.index')->with('error', 'Ekzekuto migrimet e databazes para POS-it.');
        }

        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:60',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:120',
            'sold_at' => 'nullable|date',
            'receipt_type' => 'required|in:regular,non_regular',
            'payment_method' => 'nullable|in:cash,card,bank,mixed',
            'discount' => 'nullable|numeric|min:0|max:999999',
            'paid_amount' => 'nullable|numeric|min:0|max:999999',
            'notes' => 'nullable|string|max:2000',
            'items' => 'required|array|min:1|max:80',
            'items.*.product_id' => 'nullable|integer|exists:products,id',
            'items.*.barcode' => 'nullable|string|max:120',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|integer|min:1|max:9999',
            'items.*.unit_price' => 'required|numeric|min:0|max:999999',
        ]);

        [$customer, $receipt] = DB::transaction(function () use ($data) {
            $customer = $this->resolveCustomer($data);
            $soldAt = $data['sold_at'] ?? now();
            $subtotal = 0;
            $lines = [];

            foreach ($data['items'] as $item) {
                $quantity = max((int) $item['quantity'], 1);
                $unitPrice = (float) $item['unit_price'];
                $total = $quantity * $unitPrice;
                $subtotal += $total;

                $lines[] = [
                    'product_id' => $item['product_id'] ?? null,
                    'item_name' => $item['item_name'],
                    'size' => $item['size'] ?? null,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $total,
                ];
            }

            $discount = min((float) ($data['discount'] ?? 0), $subtotal);
            $total = max($subtotal - $discount, 0);
            $paidAmount = array_key_exists('paid_amount', $data) && $data['paid_amount'] !== null && $data['paid_amount'] !== ''
                ? min((float) $data['paid_amount'], $total)
                : $total;
            $balance = max($total - $paidAmount, 0);
            $paymentStatus = $total <= 0 || $paidAmount >= $total
                ? 'paid'
                : ($paidAmount > 0 ? 'partial' : 'unpaid');

            $receipt = $customer->receipts()->create([
                'code' => $this->generateReceiptCode(),
                'receipt_type' => $data['receipt_type'],
                'source' => 'pos',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'balance' => $balance,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'payment_status' => $paymentStatus,
                'sold_at' => $soldAt,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                $customer->purchases()->create([
                    'customer_receipt_id' => $receipt->id,
                    'receipt_code' => $receipt->code,
                    'product_id' => $line['product_id'],
                    'item_name' => $line['item_name'],
                    'size' => $line['size'],
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'total' => $line['total'],
                    'purchased_at' => $soldAt,
                    'notes' => $data['notes'] ?? null,
                ]);

                $this->decrementStock($line['product_id'], $line['size'], $line['quantity']);
            }

            if (!$customer->last_purchase_at || $receipt->sold_at->greaterThan($customer->last_purchase_at)) {
                $customer->update(['last_purchase_at' => $receipt->sold_at]);
            }

            return [$customer, $receipt];
        });

        return redirect()
            ->route('admin.customers.invoice', [$customer, $receipt->code])
            ->with('success', 'Shitja u ruajt ne POS dhe fatura u krijua.');
    }

    private function resolveCustomer(array $data): Customer
    {
        $name = trim((string) ($data['customer_name'] ?? ''));
        $phone = trim((string) ($data['customer_phone'] ?? ''));
        $email = trim((string) ($data['customer_email'] ?? ''));

        $customer = null;
        if ($phone !== '' || $email !== '') {
            $customer = Customer::query()
                ->where(function ($query) use ($phone, $email) {
                    if ($phone !== '') {
                        $query->orWhere('phone', $phone);
                    }
                    if ($email !== '') {
                        $query->orWhere('email', $email);
                    }
                })
                ->first();
        }

        $payload = [
            'name' => $name !== '' ? $name : 'Klient POS',
            'phone' => $phone !== '' ? $phone : null,
            'email' => $email !== '' ? $email : null,
            'address' => $data['customer_address'] ?? null,
            'city' => $data['customer_city'] ?? null,
        ];

        if ($customer) {
            $customer->fill(array_filter($payload, fn ($value) => $value !== null && $value !== ''));
            $customer->save();

            return $customer;
        }

        return Customer::create($payload);
    }

    private function decrementStock(?int $productId, ?string $size, int $quantity): void
    {
        if (!$productId) {
            return;
        }

        $product = Product::query()->lockForUpdate()->find($productId);
        if (!$product) {
            return;
        }

        $sizes = $this->decodeProductSizes($product->sizes);
        $size = trim((string) $size);

        if ($size !== '' && !empty($sizes)) {
            foreach ($sizes as &$row) {
                if (($row['label'] ?? null) === $size) {
                    $row['stock'] = max(((int) ($row['stock'] ?? 0)) - $quantity, 0);
                    break;
                }
            }
            unset($row);

            $product->sizes = $sizes;
            $product->stock = collect($sizes)->sum(fn ($row) => (int) ($row['stock'] ?? 0));
            $product->save();

            return;
        }

        $product->stock = max(((int) ($product->stock ?? 0)) - $quantity, 0);
        $product->save();
    }

    private function productPayload(Product $product, ?array $selectedSize = null): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'price' => (float) $product->price,
            'stock' => (int) ($product->stock ?? 0),
            'image_url' => ProductImages::url($product->image_path, asset('images/placeholder-product.png'), $product),
            'sizes' => $this->decodeProductSizes($product->sizes),
            'selected_size' => $selectedSize,
        ];
    }

    private function decodeProductSizes($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value, fn ($row) => is_array($row)));
        }

        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return is_array($decoded)
            ? array_values(array_filter($decoded, fn ($row) => is_array($row)))
            : [];
    }

    private function generateReceiptCode(): string
    {
        do {
            $code = 'POS-'.now()->format('ymd').'-'.strtoupper(Str::random(5));
        } while (CustomerReceipt::where('code', $code)->exists() || CustomerPurchase::where('receipt_code', $code)->exists());

        return $code;
    }

    private function tablesReady(): bool
    {
        try {
            return Schema::hasTable('products')
                && Schema::hasTable('customers')
                && Schema::hasTable('customer_purchases')
                && Schema::hasTable('customer_receipts')
                && Schema::hasColumn('products', 'barcode')
                && Schema::hasColumn('customer_receipts', 'receipt_type')
                && Schema::hasColumn('customer_receipts', 'source')
                && Schema::hasColumn('customer_purchases', 'customer_receipt_id');
        } catch (\Throwable) {
            return false;
        }
    }
}
