<?php

namespace Tests\Feature;

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
