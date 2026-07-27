<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH USER SUDAH LOGIN
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()
                ->route('login');

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL USER YANG SEDANG LOGIN
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE USER
        |--------------------------------------------------------------------------
        */

        if ($user->role !== $role) {

            /*
            |--------------------------------------------------------------------------
            | JIKA ROLE TIDAK SESUAI
            |--------------------------------------------------------------------------
            */

            abort(
                403,
                'Anda tidak memiliki izin untuk mengakses halaman ini.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | ROLE SESUAI
        |--------------------------------------------------------------------------
        */

        return $next($request);

    }
}