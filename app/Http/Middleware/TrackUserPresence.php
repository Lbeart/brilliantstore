<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackUserPresence
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            Cache::put('user-is-online-'.$user->id, now()->timestamp, now()->addMinutes(5));
        }

        return $next($request);
    }
}
