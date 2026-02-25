<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function send(string $message): void
    {
        if (!config('services.whatsapp.enabled')) {
            return; // OFF by default
        }

        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from  = config('services.twilio.whatsapp_from');

        $toRaw = (string) config('services.whatsapp.to');
        $tos = array_filter(array_map('trim', explode(',', $toRaw)));

        foreach ($tos as $to) {
            $res = Http::asForm()
                ->withBasicAuth($sid, $token)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'From' => $from,
                    'To'   => $to,
                    'Body' => $message,
                ]);

            if (!$res->successful()) {
                logger()->error('Twilio WhatsApp failed', [
                    'to' => $to,
                    'status' => $res->status(),
                    'body' => $res->body(),
                ]);
            }
        }
    }
}