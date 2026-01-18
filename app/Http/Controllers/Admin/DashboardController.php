<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // sa sekonda me i mbajt metrikat në cache
    private int $ttl = 60;

    public function index()
    {
        $metrics = $this->getMetrics();
        // Nëse do, mund t’i dërgosh direkt në blade
        return view('admin.dashboard', $metrics);
    }

    public function metrics()
    {
        return response()->json($this->getMetrics());
    }

    private function getMetrics(): array
    {
        return Cache::remember('admin.metrics', $this->ttl, function () {
            $today      = Carbon::today();
            $monthStart = Carbon::now()->startOfMonth();

            $usersCount    = User::count();
            $productsCount = Product::count();
            $ordersCount   = Order::count();

            // të ardhurat totale (nëse do vetëm completed, shto ->where('status','completed'))
            $revenue       = Order::sum('total');

            // metrika ditore / mujore
            $todayOrders   = Order::whereDate('created_at', $today)->count();
            $todayRevenue  = Order::whereDate('created_at', $today)->sum('total');
            $monthRevenue  = Order::whereBetween('created_at', [$monthStart, now()])->sum('total');

            $avgOrderValue = $ordersCount ? round($revenue / $ordersCount, 2) : 0;

            // top 5 produktet e 30 ditëve (nga order_items)
            $since = Carbon::now()->subDays(30);
            $topProducts = DB::table('order_items as oi')
                ->join('orders as o', 'o.id', '=', 'oi.order_id')
                ->where('o.created_at', '>=', $since)
                ->select('oi.name', DB::raw('SUM(oi.qty) as total_qty'))
                ->groupBy('oi.name')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->get();

            return [
                'usersCount'    => $usersCount,
                'productsCount' => $productsCount,
                'ordersCount'   => $ordersCount,
                'revenue'       => $revenue,
                'todayOrders'   => $todayOrders,
                'todayRevenue'  => $todayRevenue,
                'monthRevenue'  => $monthRevenue,
                'avgOrderValue' => $avgOrderValue,
                'topProducts'   => $topProducts,
            ];
        });
    }
}
