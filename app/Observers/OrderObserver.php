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
        // Dërgoji email administratorëve - pavarur nga queue
        try {
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            if (!empty($admins)) {
                foreach ($admins as $email) {
                    Mail::to($email)->send(new AdminOrderNotificationMail($order));
                }
            }
        } catch (\Exception $e) {
            // Log error por mos e bllokoje porosinë
            \Log::error('Admin email send failed: ' . $e->getMessage());
        }

        SendWhatsAppOrderNotification::dispatch($order->id);
    }
}
