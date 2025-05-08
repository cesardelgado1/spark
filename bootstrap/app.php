<?php

use App\Http\Middleware\AdminOrPlanner;
use App\Http\Middleware\ContributorOrAssignee;
use App\Http\Middleware\PlannerOrContributor;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAssignee;
use App\Http\Middleware\IsContributor;
use App\Http\Middleware\IsPlanner;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            SessionTimeout::class,
        ]);

        // Route middleware aliases (still correct)
        $middleware->alias([
            'isAdmin' => IsAdmin::class,
            'isPlanner' => IsPlanner::class,
            'isContributor' => IsContributor::class,
            'isAssignee' => IsAssignee::class,
            'adminOrPlanner' => AdminOrPlanner::class,
            'PlannerOrContributor' => PlannerOrContributor::class,
            'ContributorOrAssignee' => ContributorOrAssignee::class,
            'SessionTimeout' => SessionTimeout::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
