<?php

namespace App\Http\Middleware;
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        // If user was previously logged in but now is logged out
        if (!Auth::check() && session()->has('was_authenticated')) {
            session()->forget('was_authenticated');
            return redirect('/'); // or route('home')
        }

        return $next($request);
    }
}

