<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPlanner
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->u_type === 'Planner') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

