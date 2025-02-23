<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
         // Menambahkan middleware global
         $middleware->append([
            EnsureFrontendRequestsAreStateful::class, // Middleware untuk autentikasi Sanctum
        ]);

        // Menambahkan middleware kustom
        $middleware->group('auth', [
            \App\Http\Middleware\Authenticate::class,
        ]);

        $middleware->group('role:admin', [
            \App\Http\Middleware\RoleMiddleware::class, // Middleware RBAC (buat sendiri)
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
