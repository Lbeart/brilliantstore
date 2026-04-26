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
        // Dërgoji email administratorëve pas transaction-it (use queued/async)
        try {
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            if (!empty($admins)) {
                foreach ($admins as $email) {
                    // Dërgoj në background job, jo direktë në transaction
                    \Illuminate\Support\Facades\Queue::fake(false);
                    Mail::to($email)->queue(new AdminOrderNotificationMail($order));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Admin email queue failed: ' . $e->getMessage());
        }

        // WhatsApp notification
        SendWhatsAppOrderNotification::dispatch($order->id);
    }
}
