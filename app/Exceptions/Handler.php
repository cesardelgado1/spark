<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($e instanceof AuthenticationException && $request->expectsHtml()) {
                return redirect('/?session=expired');
            }

            if ($e instanceof RouteNotFoundException && $request->expectsHtml()) {
                return redirect('/?session=expired');
            }

            return response()->view('errors.500', [], 500);
        });
    }
}
