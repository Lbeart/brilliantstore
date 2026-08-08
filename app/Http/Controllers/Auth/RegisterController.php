<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        session(['register_form_started_at' => now()->timestamp]);

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $startedAt = (int) $request->session()->pull('register_form_started_at', 0);

        // Real visitors need a moment to fill the form. Bots commonly POST it
        // directly or submit it immediately after loading the page.
        if ($request->filled('website') || $startedAt === 0 || now()->timestamp - $startedAt < 3) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'website']))
                ->withErrors(['email' => 'Regjistrimi nuk mund të përfundohej. Rifresko faqen dhe provo përsëri.']);
        }

        $turnstileToken = $request->input('cf-turnstile-response');
        $turnstileSecret = config('services.turnstile.secret_key');

        if (! $turnstileToken || ! $turnstileSecret || ! $this->turnstileIsValid($turnstileToken, $turnstileSecret, $request->ip())) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'website', 'cf-turnstile-response']))
                ->withErrors(['turnstile' => 'Verifikimi kundër robotëve dështoi. Provo përsëri.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'website' => 'nullable|max:0',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('error', 'Ju kemi dërguar një email verifikimi. Kontrolloni Inbox, Spam ose Junk dhe verifikoni emailin për t’u kyçur në b-brillant.com.');
    }

    private function turnstileIsValid(string $token, string $secret, ?string $ip): bool
    {
        try {
            return Http::asForm()
                ->timeout(8)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ])
                ->json('success') === true;
        } catch (\Throwable $exception) {
            report($exception);

            return false;
        }
    }
}
