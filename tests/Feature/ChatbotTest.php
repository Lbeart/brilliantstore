<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    public function test_it_returns_a_useful_fallback_when_ai_is_not_configured(): void
    {
        config(['services.openai.key' => null]);
        Http::fake();

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'A keni perde për sallon?',
            'history' => [],
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('action.label', 'Shiko perdet')
            ->assertJsonStructure(['reply', 'ai', 'action' => ['label', 'url']]);

        $this->assertStringContainsString('perde', mb_strtolower($response->json('reply')));
        Http::assertNothingSent();
    }

    public function test_it_uses_the_responses_api_and_extracts_output_text_safely(): void
    {
        config([
            'services.openai.key' => 'test-key',
            'services.openai.model' => 'gpt-5.4-mini',
            'services.openai.base_url' => 'https://api.openai.com/v1',
        ]);

        Http::fake([
            'api.openai.com/v1/responses' => Http::response([
                'output' => [
                    ['type' => 'reasoning', 'summary' => []],
                    [
                        'type' => 'message',
                        'role' => 'assistant',
                        'content' => [
                            ['type' => 'output_text', 'text' => 'Po, kemi disa koleksione perdesh për sallon.'],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Më ndihmo me perde.',
            'history' => [
                ['role' => 'user', 'content' => 'Përshëndetje'],
                ['role' => 'assistant', 'content' => 'Përshëndetje! Si mund të ndihmoj?'],
            ],
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('ai', true)
            ->assertJsonPath('reply', 'Po, kemi disa koleksione perdesh për sallon.');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.openai.com/v1/responses'
                && $request->hasHeader('Authorization', 'Bearer test-key')
                && $request['store'] === false
                && $request['input'][2]['role'] === 'user';
        });
    }

    public function test_it_falls_back_when_the_ai_provider_fails(): void
    {
        config(['services.openai.key' => 'test-key']);
        Http::fake(['*' => Http::response(['error' => ['message' => 'Unavailable']], 503)]);

        $this->postJson(route('chatbot.message'), ['message' => 'Sa kushton dërgesa?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonStructure(['reply']);
    }

    public function test_empty_provider_output_uses_fallback_and_is_not_marked_as_ai(): void
    {
        config(['services.openai.key' => 'test-key']);
        Http::fake(['*' => Http::response(['output' => [['type' => 'reasoning']]], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'A keni batanije?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('action.label', 'Shiko batanijet');
    }

    public function test_it_validates_message_and_history_limits(): void
    {
        config(['services.openai.key' => null]);

        $this->postJson(route('chatbot.message'), ['message' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');

        $this->postJson(route('chatbot.message'), [
            'message' => 'Përshëndetje',
            'history' => array_fill(0, 9, ['role' => 'user', 'content' => 'test']),
        ])->assertStatus(422)->assertJsonValidationErrors('history');
    }
}
