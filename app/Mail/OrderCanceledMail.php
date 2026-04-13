<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCanceledMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public ?string $reason;

    public function __construct(Order $order, ?string $reason = null)
    {
        $this->order = $order->loadMissing('items');
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Porosia juaj #' . $this->order->id . ' u anulua')
                    ->markdown('emails.orders.canceled', [
                        'order' => $this->order,
                        'reason' => $this->reason,
                    ]);
    }
}
