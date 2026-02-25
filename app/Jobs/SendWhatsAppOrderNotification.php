<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $orderId) {}

    public function handle(WhatsAppService $wa): void
    {
        // Ti e ki relation items() (e paske perdor ne view), prandaj kjo eshte OK
        $o = Order::withCount('items')->find($this->orderId);
        if (!$o) return;

        $itemsCount = $o->items_count ?? 0;

        $msg =
            "🛒 POROSI E RE #{$o->id}\n"
          . "👤 Klienti: {$o->name}\n"
          . "📞 Tel: {$o->phone}\n"
          . "📍 Adresa: {$o->address}"
          . ($o->city ? ", {$o->city}" : "")
          . ($o->zip ? " ({$o->zip})" : "")
          . "\n"
          . "🧾 Artikuj: {$itemsCount}\n"
          . "💶 Totali: " . number_format((float)$o->total, 2) . " €\n"
          . "⏰ Data: " . optional($o->created_at)->format('d.m.Y H:i');

        $wa->send($msg);
    }
}