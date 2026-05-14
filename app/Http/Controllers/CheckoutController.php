<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\ProductImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Jobs\SendWhatsAppOrderNotification;

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

            $order = Order::create($orderData);

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

    OrderItem::create([
        'order_id'   => $order->id,
        'product_id' => $it['product_id'] ?? null,
        'name'       => $it['name'] ?? 'Produkt',
        'size'       => $sizeText, // ✅ KJO do shfaqet te admin
        'qty'        => (int)($it['qty'] ?? 1),
        'price'      => (float)($it['price'] ?? 0),
        'image'      => $it['image'] ?? ($it['image_path'] ?? null),
    ]);
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
}
