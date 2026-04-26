<?php

namespace App\Observers;

use App\Jobs\SendWhatsAppOrderNotification;
use App\Mail\AdminOrderNotificationMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    public function created(Order $order): void
    {
        // Dërgoji email administratorit me të dhënat e porosisë
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new AdminOrderNotificationMail($order));
        }

        SendWhatsAppOrderNotification::dispatch($order->id);
    }
}
