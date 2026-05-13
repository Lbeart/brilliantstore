<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Models\Product;

class ItemController extends Controller
{
    public function index()
    {
        try {
            $latestProducts = Product::query()
                ->where('is_active', 1)
                ->orderByDesc('id')
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            report($e);
            $latestProducts = new Collection();
        }

        return view('items.index', compact('latestProducts'));
    }
}
