<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlannerOrContributor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && ($user->u_type === 'Contributor' || $user->u_type === 'Planner')) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
