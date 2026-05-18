<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPurchase;
use App\Models\CustomerReceipt;
use App\Models\Product;
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
        $reportYear = (int) $request->query('year', now()->year);
        $reportYear = $reportYear >= 2020 && $reportYear <= ((int) now()->year + 1) ? $reportYear : (int) now()->year;

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
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth();
        $yearStart = now()->setDate($reportYear, 1, 1)->startOfDay();
        $yearEnd = now()->setDate($reportYear, 12, 31)->endOfDay();

        $receiptBase = CustomerReceipt::query();

        $stats = [
            'customersCount' => Customer::count(),
            'receiptsCount' => CustomerReceipt::count(),
            'purchasesCount' => CustomerPurchase::count(),
            'revenue' => CustomerReceipt::sum('total'),
            'paidRevenue' => CustomerReceipt::sum('paid_amount'),
            'openBalance' => CustomerReceipt::sum('balance'),
            'todaySales' => (clone $receiptBase)->whereDate('sold_at', $today)->sum('total'),
            'todayReceipts' => (clone $receiptBase)->whereDate('sold_at', $today)->count(),
            'monthSales' => (clone $receiptBase)->whereBetween('sold_at', [$monthStart, now()])->sum('total'),
            'yearSales' => (clone $receiptBase)->whereBetween('sold_at', [$yearStart, $yearEnd])->sum('total'),
            'yearPaid' => (clone $receiptBase)->whereBetween('sold_at', [$yearStart, $yearEnd])->sum('paid_amount'),
            'yearBalance' => (clone $receiptBase)->whereBetween('sold_at', [$yearStart, $yearEnd])->sum('balance'),
            'latestCount' => Customer::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        $dailySales = CustomerReceipt::query()
            ->selectRaw('DATE(sold_at) as sale_date, COUNT(*) as receipts_count, SUM(total) as total_sales, SUM(paid_amount) as paid_sales, SUM(balance) as open_balance')
            ->whereBetween('sold_at', [$yearStart, $yearEnd])
            ->groupByRaw('DATE(sold_at)')
            ->orderByDesc('sale_date')
            ->limit(120)
            ->get();

        $monthlySales = CustomerReceipt::query()
            ->selectRaw('MONTH(sold_at) as sale_month, COUNT(*) as receipts_count, SUM(total) as total_sales, SUM(paid_amount) as paid_sales, SUM(balance) as open_balance')
            ->whereBetween('sold_at', [$yearStart, $yearEnd])
            ->groupByRaw('MONTH(sold_at)')
            ->orderBy('sale_month')
            ->get()
            ->keyBy('sale_month');

        return view('admin.customers.index', compact('customers', 'search', 'sort', 'perPage', 'stats', 'dailySales', 'monthlySales', 'reportYear'));
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
        $customer->load([
            'receipts' => fn ($q) => $q->with(['purchases', 'order'])->latest('sold_at')->latest(),
            'purchases' => fn ($q) => $q->with('order')->latest('purchased_at')->latest(),
        ]);
        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(250)
            ->get(['id', 'name', 'price', 'sku', 'stock']);

        return view('admin.customers.edit', compact('customer', 'products'));
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
        [$purchases, $total, $receipt] = $this->receiptData($customer, $receiptCode);

        return view('admin.customers.invoice', [
            'customer' => $customer,
            'purchases' => $purchases,
            'receiptCode' => $receiptCode,
            'total' => $total,
            'receipt' => $receipt,
            'isPdf' => false,
        ]);
    }

    public function invoicePdf(Customer $customer, string $receiptCode)
    {
        [$purchases, $total, $receipt] = $this->receiptData($customer, $receiptCode);

        $pdf = Pdf::loadView('admin.customers.invoice', [
            'customer' => $customer,
            'purchases' => $purchases,
            'receiptCode' => $receiptCode,
            'total' => $total,
            'receipt' => $receipt,
            'isPdf' => true,
        ]);

        return $pdf->download('fatura-'.$receiptCode.'.pdf');
    }

    public function dailyInvoice(string $date)
    {
        [$receipts, $summary, $day] = $this->dailyInvoiceData($date);

        return view('admin.customers.daily-invoice', [
            'receipts' => $receipts,
            'summary' => $summary,
            'day' => $day,
            'isPdf' => false,
        ]);
    }

    public function dailyInvoicePdf(string $date)
    {
        [$receipts, $summary, $day] = $this->dailyInvoiceData($date);

        $pdf = Pdf::loadView('admin.customers.daily-invoice', [
            'receipts' => $receipts,
            'summary' => $summary,
            'day' => $day,
            'isPdf' => true,
        ]);

        return $pdf->download('shitjet-ditore-'.$day->format('Y-m-d').'.pdf');
    }

    public function destroyPurchase(Customer $customer, CustomerPurchase $purchase)
    {
        abort_unless($purchase->customer_id === $customer->id, 404);

        $receipt = $purchase->receipt;
        $purchase->delete();

        if ($receipt) {
            $remainingPurchases = $receipt->purchases()->get();

            if ($remainingPurchases->isEmpty()) {
                $receipt->delete();
            } else {
                $subtotal = (float) $remainingPurchases->sum('total');
                $discount = min((float) $receipt->discount, $subtotal);
                $total = max($subtotal - $discount, 0);
                $paidAmount = min((float) $receipt->paid_amount, $total);
                $balance = max($total - $paidAmount, 0);
                $paymentStatus = $total <= 0 || $paidAmount >= $total
                    ? 'paid'
                    : ($paidAmount > 0 ? 'partial' : 'unpaid');

                $receipt->update([
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total' => $total,
                    'paid_amount' => $paidAmount,
                    'balance' => $balance,
                    'payment_status' => $paymentStatus,
                ]);
            }
        }

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
            'discount' => 'nullable|numeric|min:0|max:999999',
            'paid_amount' => 'nullable|numeric|min:0|max:999999',
            'payment_method' => 'nullable|in:cash,card,bank,mixed',
            'items' => 'nullable|array|max:50',
            'items.*.product_id' => 'nullable|integer|exists:products,id',
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
        $lines = [];
        $subtotal = 0;

        foreach ($data['items'] as $item) {
            $quantity = max((int) ($item['quantity'] ?? 1), 1);
            $unitPrice = (float) ($item['unit_price'] ?? 0);
            $total = array_key_exists('total', $item) && $item['total'] !== null && $item['total'] !== ''
                ? (float) $item['total']
                : $quantity * $unitPrice;

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
        $receiptTotal = max($subtotal - $discount, 0);
        $paidAmount = array_key_exists('paid_amount', $data) && $data['paid_amount'] !== null && $data['paid_amount'] !== ''
            ? (float) $data['paid_amount']
            : $receiptTotal;
        $balance = max($receiptTotal - $paidAmount, 0);
        $paymentStatus = $receiptTotal <= 0 || $paidAmount >= $receiptTotal
            ? 'paid'
            : ($paidAmount > 0 ? 'partial' : 'unpaid');

        $receipt = $customer->receipts()->create([
            'code' => $receiptCode,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $receiptTotal,
            'paid_amount' => $paidAmount,
            'balance' => $balance,
            'payment_method' => $data['payment_method'] ?? 'cash',
            'payment_status' => $paymentStatus,
            'sold_at' => $purchasedAt,
            'notes' => $data['purchase_notes'] ?? null,
        ]);

        foreach ($lines as $line) {
            $customer->purchases()->create([
                'customer_receipt_id' => $receipt->id,
                'receipt_code' => $receiptCode,
                'product_id' => $line['product_id'],
                'item_name' => $line['item_name'],
                'size' => $line['size'],
                'quantity' => $line['quantity'],
                'unit_price' => $line['unit_price'],
                'total' => $line['total'],
                'purchased_at' => $purchasedAt,
                'notes' => $data['purchase_notes'] ?? null,
            ]);
        }

        if (!$customer->last_purchase_at || $receipt->sold_at->greaterThan($customer->last_purchase_at)) {
            $customer->update(['last_purchase_at' => $receipt->sold_at]);
        }

        return $receiptCode;
    }

    private function receiptData(Customer $customer, string $receiptCode): array
    {
        $receipt = $customer->receipts()
            ->where('code', $receiptCode)
            ->with(['purchases.order', 'order'])
            ->first();

        if ($receipt) {
            return [$receipt->purchases, (float) $receipt->total, $receipt];
        }

        $purchases = $customer->purchases()
            ->where('receipt_code', $receiptCode)
            ->with('order')
            ->orderBy('id')
            ->get();

        abort_if($purchases->isEmpty(), 404);

        return [$purchases, $purchases->sum('total'), null];
    }

    private function dailyInvoiceData(string $date): array
    {
        abort_unless(preg_match('/^\d{4}-\d{2}-\d{2}$/', $date), 404);

        $day = \Carbon\Carbon::createFromFormat('Y-m-d', $date)->startOfDay();

        $receipts = CustomerReceipt::query()
            ->with(['customer', 'purchases'])
            ->whereDate('sold_at', $day->toDateString())
            ->orderBy('sold_at')
            ->orderBy('id')
            ->get();

        abort_if($receipts->isEmpty(), 404);

        $summary = [
            'receipts_count' => $receipts->count(),
            'items_count' => $receipts->sum(fn ($receipt) => $receipt->purchases->sum('quantity')),
            'subtotal' => $receipts->sum('subtotal'),
            'discount' => $receipts->sum('discount'),
            'total' => $receipts->sum('total'),
            'paid' => $receipts->sum('paid_amount'),
            'balance' => $receipts->sum('balance'),
            'cash' => $receipts->where('payment_method', 'cash')->sum('paid_amount'),
            'card' => $receipts->where('payment_method', 'card')->sum('paid_amount'),
            'bank' => $receipts->where('payment_method', 'bank')->sum('paid_amount'),
            'mixed' => $receipts->where('payment_method', 'mixed')->sum('paid_amount'),
        ];

        return [$receipts, $summary, $day];
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
                && Schema::hasTable('customer_receipts')
                && Schema::hasColumn('customer_purchases', 'receipt_code')
                && Schema::hasColumn('customer_purchases', 'customer_receipt_id');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
