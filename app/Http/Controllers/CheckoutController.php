<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\ProductImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Jobs\SendWhatsAppOrderNotification;
use App\Models\Customer;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        // ✅ Siguro URL të plota për imazhet
        foreach ($cart as &$item) {
            $item['image'] = ProductImages::url(
                $item['image'] ?? ($item['image_path'] ?? null),
                asset('images/placeholder-product.png')
            );
        }
        unset($item);

        $totalPrice = array_reduce($cart, fn($c, $i) => $c + ((float)$i['price'] * (int)$i['qty']), 0);

        // ruaje përsëri në session që edhe faqe të tjera ta kenë të fixuar
        session(['cart' => $cart]);

        return view('checkout.index', compact('cart', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout.index')->with('error','Shporta është bosh.');
        }

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:50',
            'email'   => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'city'    => 'nullable|string|max:120',
            'zip'     => 'nullable|string|max:30',
            'notes'   => 'nullable|string|max:2000',
            'payment' => 'required|in:cash,bank',
        ]);

        $total = array_reduce($cart, fn($c,$i)=> $c + ((float)$i['price'] * (int)$i['qty']), 0);

        // inicializo që me u përdor jashtë closure-it
        $order = null;

        DB::transaction(function() use ($data, $cart, $total, &$order) {
            $customer = $this->syncCustomerFromCheckout($data);

            $orderData = [
                'name'    => $data['name'],
                'phone'   => $data['phone'],
                'email'   => $data['email'] ?? (auth()->user()->email ?? null),
                'address' => $data['address'],
                'city'    => $data['city'] ?? null,
                'zip'     => $data['zip'] ?? null,
                'notes'   => $data['notes'] ?? null,
                'payment' => $data['payment'],
                'total'   => $total,
                'status'  => 'new',
            ];

            if (Schema::hasColumn('orders', 'user_id')) {
                $orderData['user_id'] = auth()->id();
            }

            if ($customer && Schema::hasColumn('orders', 'customer_id')) {
                $orderData['customer_id'] = $customer->id;
            }

            $order = Order::create($orderData);
            $customerReceipt = null;

            if ($customer && Schema::hasTable('customer_receipts')) {
                $customerReceipt = $customer->receipts()->create([
                    'order_id' => $order->id,
                    'code' => 'ORD-'.$order->id,
                    'subtotal' => $total,
                    'discount' => 0,
                    'total' => $total,
                    'paid_amount' => $total,
                    'balance' => 0,
                    'payment_method' => $data['payment'] === 'bank' ? 'bank' : 'cash',
                    'payment_status' => 'paid',
                    'sold_at' => now(),
                    'notes' => $order->notes,
                ]);
            }

           foreach ($cart as $it) {

    // default size
    $sizeText = $it['size'] ?? null;

    // ✅ nese është perde, shndërro curtain ne tekst dhe ruaje te size
    if (($it['type'] ?? null) === 'curtain' && !empty($it['curtain']) && is_array($it['curtain'])) {
        $c = $it['curtain'];

        $sizeText =
            ($c['width'] ?? '-') . "m x " . ($c['height'] ?? '-') . "m\n" .
            "Sistemi: " . ($c['fold_label'] ?? ($c['fold_type'] ?? '-')) . "\n" .
            "Material: " . ($c['meters'] ?? '-') . "m";
    }

    $orderItem = OrderItem::create([
        'order_id'   => $order->id,
        'product_id' => $it['product_id'] ?? null,
        'name'       => $it['name'] ?? 'Produkt',
        'size'       => $sizeText, // ✅ KJO do shfaqet te admin
        'qty'        => (int)($it['qty'] ?? 1),
        'price'      => (float)($it['price'] ?? 0),
        'image'      => $it['image'] ?? ($it['image_path'] ?? null),
    ]);

    if ($customer && Schema::hasTable('customer_purchases')) {
        $customer->purchases()->create([
            'customer_receipt_id' => $customerReceipt?->id,
            'order_id' => $order->id,
            'product_id' => $orderItem->product_id,
                    'receipt_code' => 'ORD-'.$order->id,
                    'item_name' => $orderItem->name,
            'size' => $orderItem->size,
            'quantity' => $orderItem->qty,
            'unit_price' => $orderItem->price,
            'total' => $orderItem->qty * $orderItem->price,
            'purchased_at' => now(),
            'notes' => $order->notes,
        ]);
    }
}

            if ($customer) {
                $customer->update(['last_purchase_at' => now()]);
            }
        });

        // dërgo njoftim WhatsApp për pronarin (në background)
        if (config('services.whatsapp.enabled')) {
            try {
                SendWhatsAppOrderNotification::dispatch($order->id);
            } catch (\Throwable $e) {
                // mos thyhet checkout nëse notifikimi dështon
            }
        }

        // pastro shportën
        session()->forget('cart');
        session()->forget('cart_total_qty');

        // ⛔️ mos e ço te admin.* (403 për userët publik)
        // ✅ dërgo te faqe publike suksesi
        return redirect()
            ->route('checkout.success')
            ->with('success','Porosia u krye me sukses!')
            ->with('order_number', $order->id)
            ->with('tracking_code', $order->tracking_code);
    }

    // ✅ faqe publike suksesi (pa admin middleware)
    public function success(Request $request)
    {
        if (!$request->session()->has('order_number') && !$request->session()->has('success')) {
            return redirect()->route('home');
        }
        $orderNo = $request->session()->get('order_number');
        return view('checkout.success', compact('orderNo'));
    }

    private function syncCustomerFromCheckout(array $data): ?Customer
    {
        if (!Schema::hasTable('customers')) {
            return null;
        }

        $customer = Customer::query()
            ->when(!empty($data['phone']), fn ($q) => $q->orWhere('phone', $data['phone']))
            ->when(!empty($data['email']), fn ($q) => $q->orWhere('email', $data['email']))
            ->first();

        if (!$customer) {
            $customer = new Customer();
        }

        $customer->fill([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? $customer->phone,
            'email' => $data['email'] ?? $customer->email,
            'address' => $data['address'] ?? $customer->address,
            'city' => $data['city'] ?? $customer->city,
        ]);

        $customer->save();

        return $customer;
    }
}
