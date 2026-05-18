<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $sort = $request->query('sort', 'latest');
        $perPage = min(max((int) $request->query('per_page', 12), 6), 100);

        $query = Customer::query()
            ->with(['purchases' => fn ($q) => $q->latest('purchased_at')->latest()->limit(3)])
            ->withCount('purchases')
            ->withSum('purchases', 'total');

        if ($search !== '') {
            $like = "%{$search}%";
            $query->where(function ($q) use ($like, $search) {
                $q->where('name', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('address', 'like', $like)
                    ->orWhere('city', 'like', $like)
                    ->orWhereHas('purchases', function ($purchase) use ($like) {
                        $purchase->where('item_name', 'like', $like)
                            ->orWhere('size', 'like', $like)
                            ->orWhere('notes', 'like', $like)
                            ->orWhereHas('order', fn ($order) => $order->where('tracking_code', 'like', $like));
                    });

                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
            });
        }

        match ($sort) {
            'name_az' => $query->orderBy('name'),
            'oldest' => $query->oldest(),
            'top' => $query->orderByDesc('purchases_sum_total'),
            default => $query->latest('last_purchase_at')->latest(),
        };

        $customers = $query->paginate($perPage)->withQueryString();

        $stats = [
            'customersCount' => Customer::count(),
            'purchasesCount' => CustomerPurchase::count(),
            'revenue' => CustomerPurchase::sum('total'),
            'latestCount' => Customer::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.customers.index', compact('customers', 'search', 'sort', 'perPage', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCustomer($request);
        $purchase = $this->validatePurchase($request, false);

        DB::transaction(function () use ($data, $purchase) {
            $customer = Customer::create($data);

            if (!empty($purchase['item_name'])) {
                $this->createPurchase($customer, $purchase);
            }
        });

        return redirect()->route('admin.customers.index')->with('success', 'Klienti u regjistrua me sukses.');
    }

    public function edit(Customer $customer)
    {
        $customer->load(['purchases' => fn ($q) => $q->with('order')->latest('purchased_at')->latest()]);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validateCustomer($request));

        return redirect()->route('admin.customers.edit', $customer)->with('success', 'Klienti u perditesua.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Klienti u fshi.');
    }

    public function storePurchase(Request $request, Customer $customer)
    {
        $purchase = $this->validatePurchase($request, true);
        $this->createPurchase($customer, $purchase);

        return redirect()->route('admin.customers.edit', $customer)->with('success', 'Blerja u shtua.');
    }

    public function destroyPurchase(Customer $customer, CustomerPurchase $purchase)
    {
        abort_unless($purchase->customer_id === $customer->id, 404);

        $purchase->delete();
        $customer->update([
            'last_purchase_at' => $customer->purchases()->max('purchased_at'),
        ]);

        return redirect()->route('admin.customers.edit', $customer)->with('success', 'Blerja u fshi.');
    }

    private function validateCustomer(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:60',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:120',
            'notes' => 'nullable|string|max:2000',
        ]);
    }

    private function validatePurchase(Request $request, bool $required): array
    {
        $itemRule = $required ? 'required|string|max:255' : 'nullable|string|max:255';

        return $request->validate([
            'item_name' => $itemRule,
            'size' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1|max:9999',
            'unit_price' => 'nullable|numeric|min:0|max:999999',
            'total' => 'nullable|numeric|min:0|max:999999',
            'purchased_at' => 'nullable|date',
            'purchase_notes' => 'nullable|string|max:2000',
        ]);
    }

    private function createPurchase(Customer $customer, array $data): CustomerPurchase
    {
        $quantity = max((int) ($data['quantity'] ?? 1), 1);
        $unitPrice = (float) ($data['unit_price'] ?? 0);
        $total = array_key_exists('total', $data) && $data['total'] !== null && $data['total'] !== ''
            ? (float) $data['total']
            : $quantity * $unitPrice;
        $purchasedAt = $data['purchased_at'] ?? now();

        $purchase = $customer->purchases()->create([
            'item_name' => $data['item_name'],
            'size' => $data['size'] ?? null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $total,
            'purchased_at' => $purchasedAt,
            'notes' => $data['purchase_notes'] ?? null,
        ]);

        if (!$customer->last_purchase_at || $purchase->purchased_at->greaterThan($customer->last_purchase_at)) {
            $customer->update(['last_purchase_at' => $purchase->purchased_at]);
        }

        return $purchase;
    }
}
