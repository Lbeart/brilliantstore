<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $base = $this->ordersForUser($user);

        $stats = [
            'orders_count' => (clone $base)->count(),
            'orders_total' => (clone $base)->sum('total'),
            'items_count' => (clone $base)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->sum('order_items.qty'),
            'last_order_at' => optional((clone $base)->latest('orders.created_at')->first())->created_at,
        ];

        $byStatus = [
            'new' => (clone $base)->where('status', 'new')->count(),
            'processing' => (clone $base)->where('status', 'processing')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'canceled' => (clone $base)->where('status', 'canceled')->count(),
        ];

        $orders = (clone $base)
            ->with('items')
            ->latest('orders.created_at')
            ->paginate(8)
            ->withQueryString();

        return view('account.dashboard', compact('user', 'stats', 'byStatus', 'orders'));
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
