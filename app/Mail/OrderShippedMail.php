<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing('items');
    }

    public function build()
    {
        return $this->subject('Porosia juaj #'.$this->order->id.' është nisur')
                    ->markdown('emails.orders.shipped', ['order' => $this->order]);
    }
}
