<?php

namespace App\Observers;

use App\Jobs\SendWhatsAppOrderNotification;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order): void
    {
        // Dërgoj WhatsApp notification
        SendWhatsAppOrderNotification::dispatch($order->id);
    }
}
