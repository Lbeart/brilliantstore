<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPurchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->tablesReady()) {
            return view('admin.customers.setup');
        }

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
        if (!$this->tablesReady()) {
            return redirect()->route('admin.customers.index')->with('error', 'Duhet te ekzekutohet migrimi i databazes para regjistrimit te klienteve.');
        }

        $data = $this->validateCustomer($request);
        $purchase = $this->validatePurchaseBatch($request, false);

        [$customer, $receiptCode] = DB::transaction(function () use ($data, $purchase) {
            $customer = Customer::create($data);
            $receiptCode = null;

            if (!empty($purchase['items'])) {
                $receiptCode = $this->createPurchaseBatch($customer, $purchase);
            }

            return [$customer, $receiptCode];
        });

        if ($receiptCode) {
            return redirect()->route('admin.customers.invoice', [$customer, $receiptCode])->with('success', 'Klienti u regjistrua dhe fatura u krijua.');
        }

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
        $purchase = $this->validatePurchaseBatch($request, true);
        $receiptCode = $this->createPurchaseBatch($customer, $purchase);

        return redirect()->route('admin.customers.invoice', [$customer, $receiptCode])->with('success', 'Blerja u shtua dhe fatura u krijua.');
    }

    public function invoice(Customer $customer, string $receiptCode)
    {
        [$purchases, $total] = $this->receiptData($customer, $receiptCode);

        return view('admin.customers.invoice', [
            'customer' => $customer,
            'purchases' => $purchases,
            'receiptCode' => $receiptCode,
            'total' => $total,
            'isPdf' => false,
        ]);
    }

    public function invoicePdf(Customer $customer, string $receiptCode)
    {
        [$purchases, $total] = $this->receiptData($customer, $receiptCode);

        $pdf = Pdf::loadView('admin.customers.invoice', [
            'customer' => $customer,
            'purchases' => $purchases,
            'receiptCode' => $receiptCode,
            'total' => $total,
            'isPdf' => true,
        ]);

        return $pdf->download('fatura-'.$receiptCode.'.pdf');
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

    private function validatePurchaseBatch(Request $request, bool $required): array
    {
        $data = $request->validate([
            'purchased_at' => 'nullable|date',
            'purchase_notes' => 'nullable|string|max:2000',
            'items' => 'nullable|array|max:50',
            'items.*.item_name' => 'nullable|string|max:255',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.quantity' => 'nullable|integer|min:1|max:9999',
            'items.*.unit_price' => 'nullable|numeric|min:0|max:999999',
            'items.*.total' => 'nullable|numeric|min:0|max:999999',
        ]);

        $items = collect($data['items'] ?? [])
            ->filter(fn ($item) => trim((string) ($item['item_name'] ?? '')) !== '')
            ->values()
            ->all();

        if ($required && count($items) === 0) {
            throw ValidationException::withMessages([
                'items.0.item_name' => 'Shto te pakten nje produkt per fature.',
            ]);
        }

        $data['items'] = $items;

        return $data;
    }

    private function createPurchaseBatch(Customer $customer, array $data): string
    {
        $receiptCode = $this->generateReceiptCode();
        $purchasedAt = $data['purchased_at'] ?? now();
        $latestPurchase = null;

        foreach ($data['items'] as $item) {
            $quantity = max((int) ($item['quantity'] ?? 1), 1);
            $unitPrice = (float) ($item['unit_price'] ?? 0);
            $total = array_key_exists('total', $item) && $item['total'] !== null && $item['total'] !== ''
                ? (float) $item['total']
                : $quantity * $unitPrice;

            $latestPurchase = $customer->purchases()->create([
                'receipt_code' => $receiptCode,
                'item_name' => $item['item_name'],
                'size' => $item['size'] ?? null,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total' => $total,
                'purchased_at' => $purchasedAt,
                'notes' => $data['purchase_notes'] ?? null,
            ]);
        }

        if ($latestPurchase && (!$customer->last_purchase_at || $latestPurchase->purchased_at->greaterThan($customer->last_purchase_at))) {
            $customer->update(['last_purchase_at' => $latestPurchase->purchased_at]);
        }

        return $receiptCode;
    }

    private function receiptData(Customer $customer, string $receiptCode): array
    {
        $purchases = $customer->purchases()
            ->where('receipt_code', $receiptCode)
            ->with('order')
            ->orderBy('id')
            ->get();

        abort_if($purchases->isEmpty(), 404);

        return [$purchases, $purchases->sum('total')];
    }

    private function generateReceiptCode(): string
    {
        do {
            $code = 'BRL-'.now()->format('ymd').'-'.strtoupper(Str::random(5));
        } while (CustomerPurchase::where('receipt_code', $code)->exists());

        return $code;
    }

    private function tablesReady(): bool
    {
        try {
            return Schema::hasTable('customers')
                && Schema::hasTable('customer_purchases')
                && Schema::hasColumn('customer_purchases', 'receipt_code');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
