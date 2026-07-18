<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $queryLocale = $request->query('lang');
        $locale = in_array($queryLocale, ['sq', 'en', 'sr'], true)
            ? $queryLocale
            : $request->session()->get('locale', config('app.locale', 'sq'));

        if (! in_array($locale, ['sq', 'en', 'sr'], true)) {
            $locale = 'sq';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
