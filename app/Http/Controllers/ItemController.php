<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ItemController extends Controller
{
    public function index()
    {
        $latestProducts = Product::query()
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->take(6)
            ->get();

        return view('items.index', compact('latestProducts'));
    }
}
