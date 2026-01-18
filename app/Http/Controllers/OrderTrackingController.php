<?php

// app/Http/Controllers/OrderTrackingController.php

namespace App\Http\Controllers;



use App\Models\Order;



class OrderTrackingController extends Controller

{

    // formular i thjeshtë (opsional – mund ta vësh kudo si komponent)

    public function form()

    {

        return view('track.show');

    }



    // shfaq statusin sipas kodit

    public function show(string $code)

    {

        $order = Order::with('items')->where('tracking_code', $code)->firstOrFail();

        return view('track.show', compact('order'));

    }

}