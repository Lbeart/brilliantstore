<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $allowedStatuses = ['new', 'processing', 'completed', 'canceled'];
        $status = $request->query('status');
        $search = trim((string) $request->query('q', ''));

        $base = $this->ordersForUser($user);
        $orderIds = (clone $base)->pluck('orders.id');

        $stats = [
            'orders_count' => (clone $base)->count(),
            'orders_total' => (clone $base)->sum('total'),
            'items_count' => $orderIds->isEmpty() ? 0 : DB::table('order_items')->whereIn('order_id', $orderIds)->sum('qty'),
            'last_order_at' => optional((clone $base)->latest('orders.created_at')->first())->created_at,
        ];

        $byStatus = [
            'new' => (clone $base)->where('status', 'new')->count(),
            'processing' => (clone $base)->where('status', 'processing')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'canceled' => (clone $base)->where('status', 'canceled')->count(),
        ];

        $lastOrder = (clone $base)
            ->latest('orders.created_at')
            ->first();

        $recentItems = $orderIds->isEmpty()
            ? collect()
            : DB::table('order_items')
                ->whereIn('order_id', $orderIds)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

        $topItems = $orderIds->isEmpty()
            ? collect()
            : DB::table('order_items')
                ->select('name', DB::raw('SUM(qty) as qty'))
                ->whereIn('order_id', $orderIds)
                ->groupBy('name')
                ->orderByDesc('qty')
                ->limit(4)
                ->get();

        $ordersQuery = (clone $base);

        if (in_array($status, $allowedStatuses, true)) {
            $ordersQuery->where('status', $status);
        }

        if ($search !== '') {
            $like = "%{$search}%";
            $ordersQuery->where(function ($query) use ($like, $search) {
                $query->where('tracking_code', 'like', $like)
                    ->orWhere('name', 'like', $like)
                    ->orWhere('phone', 'like', $like);

                if (is_numeric($search)) {
                    $query->orWhere('orders.id', (int) $search);
                }
            });
        }

        $orders = $ordersQuery
            ->with('items.product')
            ->latest('orders.created_at')
            ->paginate(8)
            ->withQueryString();

        return view('account.dashboard', compact(
            'user',
            'stats',
            'byStatus',
            'orders',
            'lastOrder',
            'recentItems',
            'topItems',
            'status',
            'search'
        ));
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $request->user()->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('password_success', 'Fjalëkalimi u ndryshua me sukses.');
    }

    private function ordersForUser($user)
    {
        return Order::query()
            ->select('orders.*')
            ->where(function ($query) use ($user) {
                if (Schema::hasColumn('orders', 'user_id')) {
                    $query->where('user_id', $user->id);
                }

                $query->orWhere(function ($emailQuery) use ($user) {
                    $emailQuery
                        ->whereNotNull('email')
                        ->where('email', $user->email);
                });
            });
    }
}
