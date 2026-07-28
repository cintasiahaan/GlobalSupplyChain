<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\RoleMiddleware;

return Application::configure(
    basePath: dirname(__DIR__)
)
    ->withRouting(

        web: __DIR__ . '/../routes/web.php',

        api: __DIR__ . '/../routes/api.php',

        commands: __DIR__ . '/../routes/console.php',

        health: '/up',

    )


    ->withMiddleware(function (
        Middleware $middleware
    ) {

        /*
        |--------------------------------------------------------------------------
        | ROLE MIDDLEWARE
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk membatasi akses berdasarkan role:
        |
        | role:admin
        | role:user
        |
        */

        $middleware->alias([

            'role' => RoleMiddleware::class,

        ]);

    })

    ->withExceptions(function (
        Exceptions $exceptions
    ) {

        /*
        |--------------------------------------------------------------------------
        | AUTHENTICATION EXCEPTION → REDIRECT TO LOGIN
        |--------------------------------------------------------------------------
        |
        | Explicitly redirect unauthenticated users to the login page.
        | This must be handled BEFORE the generic debug renderer so it
        | is not swallowed and shown as a plain error page.
        |
        */

        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('login'));
        });

    })

    ->create();