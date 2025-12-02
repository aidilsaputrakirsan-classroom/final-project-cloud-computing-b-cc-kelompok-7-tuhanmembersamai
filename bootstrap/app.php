<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // register route middleware aliases
        $middleware->alias([
            // keep existing alias (camelCase) for backward compatibility
            'isLogin'  => \App\Http\Middleware\IsLogin::class,
            // add dot-case alias (preferred/common style)
            'is.login' => \App\Http\Middleware\IsLogin::class,

            // admin middleware
            'isAdmin'  => \App\Http\Middleware\IsAdmin::class,
            'is.admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
