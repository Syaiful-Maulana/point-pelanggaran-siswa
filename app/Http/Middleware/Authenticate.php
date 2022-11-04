<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            switch ($request->segment(1)) {
                case 'admin':
                    return route('login-admin');
                    break;

                case 'guru':
                    return route('login-guru');
                    break;

                default:
                    return route('login');
                    break;
            }
        }
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    }
}
