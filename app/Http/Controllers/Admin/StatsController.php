<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        $now   = Carbon::now();
        $today = $now->copy()->startOfDay();

        // ===== KPI =====
        $kpi = [];

        // Sot
        $todayOrdersQ = Order::whereBetween('created_at', [$today, $today->copy()->endOfDay()]);
        $kpi['today_orders']  = (clone $todayOrdersQ)->count();
        $kpi['today_revenue'] = (clone $todayOrdersQ)->sum('total');
        $kpi['today_avg']     = $kpi['today_orders'] ? round($kpi['today_revenue'] / $kpi['today_orders'], 2) : 0;

        $yesterday = $today->copy()->subDay();
        $yesterdayCount = Order::whereBetween('created_at', [$yesterday, $yesterday->copy()->endOfDay()])->count();
        $diff = $kpi['today_orders'] - $yesterdayCount;
        $kpi['today_vs_yesterday'] = ($diff >= 0 ? '+' : '').$diff.' porosi';

        // Muaji
        $monthStart = $now->copy()->startOfMonth();
        $monthQ = Order::whereBetween('created_at', [$monthStart, $now]);
        $kpi['month_orders']  = (clone $monthQ)->count();
        $kpi['month_revenue'] = (clone $monthQ)->sum('total');

        // Viti
        $yearStart = $now->copy()->startOfYear();
        $yearQ = Order::whereBetween('created_at', [$yearStart, $now]);
        $kpi['year_orders']  = (clone $yearQ)->count();
        $kpi['year_revenue'] = (clone $yearQ)->sum('total');

        // Nëse ka filter date, përdore për grafiqe; përndryshe default ranges
        $rangeDailyFrom   = $from ? Carbon::parse($from)->startOfDay() : $today->copy()->subDays(29);
        $rangeDailyTo     = $to   ? Carbon::parse($to)->endOfDay()   : $today->copy()->endOfDay();

        $rangeMonthlyFrom = $from ? Carbon::parse($from)->startOfMonth() : $now->copy()->startOfMonth()->subMonths(11);
        $rangeMonthlyTo   = $to   ? Carbon::parse($to)->endOfMonth()   : $now;

        $rangeYearlyFrom  = $from ? Carbon::parse($from)->startOfYear() : $now->copy()->startOfYear()->subYears(4);
        $rangeYearlyTo    = $to   ? Carbon::parse($to)->endOfYear()     : $now;

        // ===== Daily (30 ditët e fundit ose sipas filtër) =====
        $dailyRaw = DB::table('orders')
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c, COALESCE(SUM(total),0) as s')
            ->whereBetween('created_at', [$rangeDailyFrom, $rangeDailyTo])
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        $dailyLabels = [];
        $dailyOrders = [];
        $dailyRevenue = [];
        $cursor = $rangeDailyFrom->copy()->startOfDay();
        while ($cursor <= $rangeDailyTo) {
            $key = $cursor->toDateString();
            $dailyLabels[]  = $cursor->format('d M');
            $dailyOrders[]  = isset($dailyRaw[$key]) ? (int)$dailyRaw[$key]->c : 0;
            $dailyRevenue[] = isset($dailyRaw[$key]) ? (float)$dailyRaw[$key]->s : 0.0;
            $cursor->addDay();
        }

        $daily = [
            'labels'  => $dailyLabels,
            'orders'  => $dailyOrders,
            'revenue' => $dailyRevenue,
        ];

        // ===== Monthly (12 muajt e fundit ose sipas filtër) =====
        $monthlyRaw = DB::table('orders')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as c, COALESCE(SUM(total),0) as s')
            ->whereBetween('created_at', [$rangeMonthlyFrom, $rangeMonthlyTo])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $monthlyLabels = [];
        $monthlyOrders = [];
        $monthlyRevenue = [];
        $cursor = $rangeMonthlyFrom->copy()->startOfMonth();
        while ($cursor <= $rangeMonthlyTo) {
            $key = $cursor->format('Y-m');
            $monthlyLabels[]  = $cursor->isoFormat('MMM YYYY'); // p.sh. Tet 2025
            $monthlyOrders[]  = isset($monthlyRaw[$key]) ? (int)$monthlyRaw[$key]->c : 0;
            $monthlyRevenue[] = isset($monthlyRaw[$key]) ? (float)$monthlyRaw[$key]->s : 0.0;
            $cursor->addMonth();
        }

        $monthly = [
            'labels'  => $monthlyLabels,
            'orders'  => $monthlyOrders,
            'revenue' => $monthlyRevenue,
        ];

        // ===== Yearly (5 vitet e fundit ose sipas filtër) =====
        $yearlyRaw = DB::table('orders')
            ->selectRaw('YEAR(created_at) as y, COUNT(*) as c, COALESCE(SUM(total),0) as s')
            ->whereBetween('created_at', [$rangeYearlyFrom, $rangeYearlyTo])
            ->groupBy('y')
            ->orderBy('y')
            ->get()
            ->keyBy('y');

        $yearlyLabels = [];
        $yearlyOrders = [];
        $yearlyRevenue = [];
        $cursor = $rangeYearlyFrom->copy()->startOfYear();
        while ($cursor->year <= $rangeYearlyTo->year) {
            $key = $cursor->year;
            $yearlyLabels[]  = (string)$key;
            $yearlyOrders[]  = isset($yearlyRaw[$key]) ? (int)$yearlyRaw[$key]->c : 0;
            $yearlyRevenue[] = isset($yearlyRaw[$key]) ? (float)$yearlyRaw[$key]->s : 0.0;
            $cursor->addYear();
        }

        $yearly = [
            'labels'  => $yearlyLabels,
            'orders'  => $yearlyOrders,
            'revenue' => $yearlyRevenue,
        ];

        return view('admin.statistika', [
            'kpi'     => $kpi,
            'daily'   => $daily,
            'monthly' => $monthly,
            'yearly'  => $yearly,
            'from'    => $from,
            'to'      => $to,
        ]);
    }
}
