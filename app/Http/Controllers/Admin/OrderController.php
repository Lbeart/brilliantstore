<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // ⬅️ SHTUAR
use App\Mail\OrderCanceledMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class OrderController extends Controller
{
    /**
     * Porositë e SOTME (me kërkim dhe filtër statusi)
     */
    public function index(Request $request)
    {
        $status = $request->query('status');          // new, processing, completed, canceled
        $search = trim($request->query('q', ''));     // emër / tel / email / #id / KOD / NUMËR

        // 🔒 "Sot" sipas APP timezone (e konvertojmë në UTC për DB)
        $tz    = config('app.timezone', 'UTC');
        $start = now($tz)->startOfDay()->utc();
        $end   = now($tz)->endOfDay()->utc();

        // ⬇️ cache flags për kolonat opsionale, që të mos bëjmë hasColumn në çdo orWhere
        $hasOrderNumber = Schema::hasColumn('orders', 'order_number');
        $hasUuid        = Schema::hasColumn('orders', 'uuid');
        $hasReference   = Schema::hasColumn('orders', 'reference');

        $base = Order::query()
            ->withCount('items')
            ->whereBetween('created_at', [$start, $end]); // ✅ veç sot

        if ($search !== '') {
            $like = "%{$search}%";
            $base->where(function ($q) use ($search, $like, $hasOrderNumber, $hasUuid, $hasReference) {
                $q->where('name',  'like', $like)
                  ->orWhere('phone','like', $like)
                  ->orWhere('email','like', $like)
                  ->orWhere('tracking_code', 'like', $like);

                // 🔎 vetëm nëse ekziston kolona në DB
                if ($hasOrderNumber) { $q->orWhere('order_number', 'like', $like); }
                if ($hasUuid)        { $q->orWhere('uuid',         'like', $like); }
                if ($hasReference)   { $q->orWhere('reference',    'like', $like); }

                if (is_numeric($search)) {
                    $q->orWhere('id', (int)$search);
                }
            });
        }

        if ($status) {
            $base->where('status', $status);
        }

        $orders = $base->latest()->paginate(12)->withQueryString();

        return view('admin.porosite', compact('orders', 'status', 'search'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.porosia', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:new,processing,completed,canceled',
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Statusi u përditësua.');
    }

    public function sendConfirmationEmail(Order $order)
    {
         
        if (!$order->email) {
            return back()->with('error', 'Kjo porosi nuk ka email të klientit.');
        }

        $order->load('items');
        Mail::to($order->email)->send(new OrderConfirmationMail($order));

        return back()->with('success', 'Emaili i konfirmimit u dërgua te klienti.');
    }

    public function sendShippedEmail(Order $order)
    {
        if (!$order->email) {
            return back()->with('error', 'Kjo porosi nuk ka email të klientit.');
        }

        $order->load('items');
        Mail::to($order->email)->send(new OrderShippedMail($order));

        // opsionale: nëse ishte "new", kalo në "processing"
        if ($order->status === 'new') {
            $order->update(['status' => 'processing']);
        }

        return back()->with('success', 'Emaili “Porosia është nisur” u dërgua.');
    }

    public function sendCanceledEmail(Request $request, Order $order)
    {
        if (!$order->email) {
            return back()->with('error', 'Kjo porosi nuk ka email të klientit.');
        }

        $data = $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $order->load('items');
        Mail::to($order->email)->send(new OrderCanceledMail($order, $data['reason'] ?? null));

        if ($order->status !== 'canceled') {
            $order->update(['status' => 'canceled']);
        }

        return back()->with('success', 'Emaili i anullimit u dërgua te klienti.');
    }

    public function destroy(Order $order)
    {
        // order_items me FK -> cascadeOnDelete, fshihen vetë
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Porosia u fshi.');
    }

    /**
     * Krejt porositë (me kërkim + data + statistika)
     */
    public function all(Request $request)
    {
        $search = trim($request->query('q', ''));
        $from   = $request->query('from');
        $to     = $request->query('to');

        // ⬇️ cache flags për kolonat opsionale
        $hasOrderNumber = Schema::hasColumn('orders', 'order_number');
        $hasUuid        = Schema::hasColumn('orders', 'uuid');
        $hasReference   = Schema::hasColumn('orders', 'reference');

        $base = Order::query()->withCount('items');

        if ($search !== '') {
            $like = "%{$search}%";
            $base->where(function ($q) use ($search, $like, $hasOrderNumber, $hasUuid, $hasReference) {
                $q->where('name',  'like', $like)
                  ->orWhere('phone','like', $like)
                  ->orWhere('email','like', $like)
                  ->orWhere('tracking_code', 'like', $like);

                // 🔎 vetëm nëse ekziston kolona në DB
                if ($hasOrderNumber) { $q->orWhere('order_number', 'like', $like); }
                if ($hasUuid)        { $q->orWhere('uuid',         'like', $like); }
                if ($hasReference)   { $q->orWhere('reference',    'like', $like); }

                if (is_numeric($search)) {
                    $q->orWhere('id', (int)$search);
                }
            });
        }

        if ($from) { $base->whereDate('created_at', '>=', $from); }
        if ($to)   { $base->whereDate('created_at', '<=', $to); }

        $orders = (clone $base)->latest()->get();

        // Stats
        $count   = (clone $base)->count();
        $revenue = (clone $base)->sum('total');
        $avg     = $count ? round($revenue / $count, 2) : 0;

        // Artikuj gjithsej (nga order_items)
        $orderIds = $orders->pluck('id');
        $itemsQty = $orderIds->isEmpty()
            ? 0
            : DB::table('order_items')->whereIn('order_id', $orderIds)->sum('qty');

        $byStatus = [
            'new'        => (clone $base)->where('status','new')->count(),
            'processing' => (clone $base)->where('status','processing')->count(),
            'completed'  => (clone $base)->where('status','completed')->count(),
            'canceled'   => (clone $base)->where('status','canceled')->count(),
        ];

        return view('admin.porosite_all', compact(
            'orders','count','revenue','avg','itemsQty','byStatus','search','from','to'
        ));
    }

    public function invoice(Order $order)
{
    $order->load('items');
    return view('admin.fatura', [
    'order' => $order,
    'isPdf' => false
]);
}
public function invoicePdf(Order $order)
{
    $order->load('items');

    $qr = base64_encode(
        QrCode::format('png')
            ->size(120)
            ->generate(route('admin.orders.show', $order->id))
    );

    $pdf = Pdf::loadView('admin.fatura', [
        'order' => $order,
        'isPdf' => true,
        'qr' => $qr
    ]);

    return $pdf->download('fatura-'.$order->id.'.pdf');
}
public function sendInvoice(Order $order)
{
    if (!$order->email) {
        return back()->with('error', 'Kjo porosi nuk ka email.');
    }

    $order->load('items');

   $qr = base64_encode(
    QrCode::format('png')
        ->size(120)
        ->generate(route('admin.orders.show', $order->id))
);

$pdf = Pdf::loadView('admin.fatura', [
    'order' => $order,
    'isPdf' => true,
    'qr' => $qr
]);

    Mail::send([], [], function ($message) use ($order, $pdf) {
        $message->to($order->email)
            ->subject('Fatura juaj - Brillant')
            ->attachData($pdf->output(), 'fatura-'.$order->id.'.pdf');
    });

    return back()->with('success', 'Fatura u dërgua me sukses!');
}
public function invoicePublic($id)
{
    $order = Order::with('items')->findOrFail($id);

    $qr = base64_encode(
        \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(120)
            ->generate(route('orders.track', $order->tracking_code))
    );

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.fatura', [
        'order' => $order,
        'isPdf' => true,
        'qr' => $qr
    ]);

    return $pdf->download('fatura-'.$order->id.'.pdf');
}
}
