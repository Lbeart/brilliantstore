<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q'));

        if (!$q) {
            return redirect()->back();
        }

        $items = Item::where('name', 'LIKE', "%{$q}%")
            ->orWhere('description', 'LIKE', "%{$q}%")
            ->latest()
            ->get();

        return view('search-results', [
            'items' => $items,
            'q' => $q
        ]);
    }
}