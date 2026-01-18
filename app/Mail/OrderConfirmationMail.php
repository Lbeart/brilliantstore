<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing('items');
    }

    public function build()
    {
        return $this->subject('Konfirmimi i porosisë #'.$this->order->id)
                    ->markdown('emails.orders.confirmation', [
                        'order' => $this->order,
                    ]);
    }
}