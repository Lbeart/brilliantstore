<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale', config('app.locale', 'sq'));

        if (!in_array($locale, ['sq', 'en', 'sr'], true)) {
            $locale = 'sq';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
