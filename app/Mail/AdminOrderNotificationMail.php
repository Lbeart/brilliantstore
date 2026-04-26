<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing('items');
    }

    public function build()
    {
        return $this->subject('Porosi e re - #'.$this->order->tracking_code)
                    ->markdown('emails.orders.admin-notification', [
                        'order' => $this->order,
                    ]);
    }
}
