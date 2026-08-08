<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegistrationProtectionTest extends TestCase
{
    public function test_direct_registration_post_is_rejected(): void
    {
        $response = $this->post('/register', $this->validRegistrationData());

        $response->assertSessionHasErrors('email');
    }

    public function test_honeypot_registration_is_rejected(): void
    {
        $response = $this->withSession([
            'register_form_started_at' => now()->subSeconds(5)->timestamp,
        ])->post('/register', array_merge($this->validRegistrationData(), [
            'website' => 'https://spam.example',
        ]));

        $response->assertSessionHasErrors('email');
    }

    public function test_invalid_turnstile_token_is_rejected(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => false]),
        ]);

        $response = $this->withSession([
            'register_form_started_at' => now()->subSeconds(5)->timestamp,
        ])->post('/register', array_merge($this->validRegistrationData(), [
            'cf-turnstile-response' => 'invalid-token',
        ]));

        $response->assertSessionHasErrors('turnstile');
        Http::assertSentCount(1);
    }

    private function validRegistrationData(): array
    {
        return [
            'name' => 'Real Person',
            'email' => 'person@example.com',
            'password' => 'strong-password',
            'password_confirmation' => 'strong-password',
        ];
    }
}
