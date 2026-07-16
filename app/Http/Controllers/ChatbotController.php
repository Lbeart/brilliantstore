<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ChatbotController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:600'],
            'history' => ['sometimes', 'array', 'max:8'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:600'],
        ]);

        $message = trim($validated['message']);
        $history = collect($validated['history'] ?? [])
            ->take(-8)
            ->map(fn (array $item) => [
                'role' => $item['role'],
                'content' => trim($item['content']),
            ])
            ->filter(fn (array $item) => $item['content'] !== '')
            ->values()
            ->all();

        $action = $this->suggestedAction($message);
        $apiKey = trim((string) config('services.openai.key'));

        if ($apiKey === '') {
            return response()->json([
                'reply' => $this->fallbackReply($message),
                'ai' => false,
                'action' => $action,
            ]);
        }

        try {
            $input = [...$history, ['role' => 'user', 'content' => $message]];
            $baseUrl = rtrim((string) config('services.openai.base_url', 'https://api.openai.com/v1'), '/');

            $response = Http::acceptJson()
                ->asJson()
                ->withToken($apiKey)
                ->connectTimeout(5)
                ->timeout(25)
                ->retry(2, 250, function (Throwable $exception) {
                    if ($exception instanceof ConnectionException) {
                        return true;
                    }

                    if ($exception instanceof RequestException) {
                        $status = $exception->response->status();

                        return $status === 429 || $status >= 500;
                    }

                    return false;
                }, false)
                ->post($baseUrl.'/responses', [
                    'model' => config('services.openai.model', 'gpt-5.4-mini'),
                    'store' => false,
                    'max_output_tokens' => 500,
                    'reasoning' => ['effort' => 'low'],
                    'instructions' => $this->instructions(),
                    'input' => $input,
                ]);

            if (! $response->successful()) {
                Log::warning('Brillant chatbot API request failed.', [
                    'status' => $response->status(),
                    'request_id' => $response->header('x-request-id'),
                ]);

                return response()->json([
                    'reply' => $this->fallbackReply($message),
                    'ai' => false,
                    'action' => $action,
                ]);
            }

            $reply = $this->extractText($response->json());
            $usedAi = $reply !== '';

            if (! $usedAi) {
                $reply = $this->fallbackReply($message);
            }

            return response()->json([
                'reply' => Str::limit($reply, 1200, ''),
                'ai' => $usedAi,
                'action' => $action,
            ]);
        } catch (Throwable $exception) {
            Log::warning('Brillant chatbot could not reach the AI service.', [
                'exception' => $exception::class,
            ]);

            return response()->json([
                'reply' => $this->fallbackReply($message),
                'ai' => false,
                'action' => $action,
            ]);
        }
    }

    private function instructions(): string
    {
        return <<<'PROMPT'
Ti je asistenti i dyqanit B-Brillant në Lipjan, Kosovë. Përgjigju në gjuhën e klientit, me ton të ngrohtë, profesional dhe të shkurtër (maksimumi 4 fjali).
B-Brillant shet tepiha, perde ditore dhe anësore, sete çarçafësh/postava, batanije, mbulesa, jastëkë dekorues, tepiha banjoje, lëkurë pelushi dhe garnisha. Ofron këshillim për kombinim, matje dhe montim të perdeve sipas mundësisë, si dhe dërgesë në Kosovë.
Mos shpik çmime, stok, afate ose status porosie. Për këto kërkoji klientit ta hapë produktin përkatës ose të kontaktojë ekipin në WhatsApp në +383 44 960 661. Mos kërko të dhëna të kartelës, fjalëkalime apo informacione të ndjeshme. Për gjurmim porosie drejtoje te faqja e gjurmimit.
PROMPT;
    }

    private function extractText(array $payload): string
    {
        $parts = [];

        foreach ($payload['output'] ?? [] as $output) {
            if (($output['type'] ?? null) !== 'message') {
                continue;
            }

            foreach ($output['content'] ?? [] as $content) {
                if (($content['type'] ?? null) === 'output_text' && is_string($content['text'] ?? null)) {
                    $parts[] = trim($content['text']);
                }
            }
        }

        return trim(implode("\n", array_filter($parts)));
    }

    private function fallbackReply(string $message): string
    {
        $normalized = Str::lower($message);

        if (Str::contains($normalized, ['porosi', 'porosia', 'gjurmo', 'kodi', 'tracking'])) {
            return 'Për ta kontrolluar porosinë, hape faqen “Gjurmo porosinë” dhe vendose kodin që ke marrë. Nëse nuk e ke kodin, na shkruaj në WhatsApp dhe ekipi të ndihmon.';
        }

        if (Str::contains($normalized, ['perde', 'dritare', 'matje', 'montim'])) {
            return 'Kemi perde ditore dhe anësore, me ndihmë për kombinim, matje dhe montim sipas mundësisë. Shiko koleksionin ose na dërgo në WhatsApp një foto të dritares dhe përmasat.';
        }

        if (Str::contains($normalized, ['tepih', 'tepiha', 'tapet'])) {
            return 'Kemi tepiha për sallon, dhomë gjumi dhe korridor në stile e përmasa të ndryshme. Hape koleksionin e tepiheve; për stokun dhe çmimin e modelit të pëlqyer na shkruaj në WhatsApp.';
        }

        if (Str::contains($normalized, ['çmim', 'cmim', 'stok', 'stock', 'kushton', 'disponuesh'])) {
            return 'Çmimi dhe stoku varen nga modeli dhe përmasa. Hape produktin që të pëlqen ose dërgo foton e tij në WhatsApp që ekipi ta konfirmojë menjëherë.';
        }

        if (Str::contains($normalized, ['dërges', 'derges', 'transport', 'qytet'])) {
            return 'B-Brillant bën dërgesa në Kosovë. Për çmimin dhe kohën e saktë të dërgesës, na trego qytetin dhe produktin në WhatsApp.';
        }

        return 'Mund të të ndihmoj me perde, tepiha, tekstile për shtëpi, dërgesë ose gjurmim porosie. Shkruaj çfarë po kërkon, ose na kontakto direkt në WhatsApp për përgjigje nga ekipi.';
    }

    private function suggestedAction(string $message): ?array
    {
        $normalized = Str::lower($message);

        $actions = [
            [['porosi', 'gjurmo', 'tracking'], 'Gjurmo porosinë', route('track.form', [], false)],
            [['perde anësore', 'perde anesore'], 'Shiko perdet anësore', route('products.anesore', [], false)],
            [['perde', 'dritare'], 'Shiko perdet', route('products.perdeDitore', [], false)],
            [['tepih banjo', 'banjo'], 'Shiko tepihat e banjos', route('products.tepihebanjo', [], false)],
            [['tepih', 'tepiha', 'tapet'], 'Shiko tepihat', route('products.tepiha', [], false)],
            [['batanije', 'qebe'], 'Shiko batanijet', route('products.batanije', [], false)],
            [['çarçaf', 'carcaf', 'postava'], 'Shiko setet e çarçafëve', route('products.postava', [], false)],
            [['mbulesa', 'mbulesë', 'divan'], 'Shiko mbulesat', route('products.mbulesa', [], false)],
            [['jastëk', 'jastek'], 'Shiko jastëkët', route('products.jastekdekorues', [], false)],
        ];

        foreach ($actions as [$needles, $label, $url]) {
            if (Str::contains($normalized, $needles)) {
                return ['label' => $label, 'url' => $url];
            }
        }

        return null;
    }
}
