<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContributorOrAssignee
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && ($user->u_type === 'Contributor' || $user->u_type === 'Assignee')) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
