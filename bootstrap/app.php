<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CartItemCount;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'cart-item-count' => \App\Http\Middleware\CartItemCount::class,
        ]);
        $middleware->validateCsrfTokens(except: [
        '/payment/redirect',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
