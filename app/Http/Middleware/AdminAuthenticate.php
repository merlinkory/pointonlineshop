<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Exceptions\AppException;

class AdminAuthenticate extends Middleware {

    public function handle($request, Closure $next, ...$guards) {
        if (!$request->user())
            abort(403);

        if (!$request->user()->roles()->where('role', 'admin')->exists()) {

            throw new \Exception('Unauthenticated. Admin role required', 403);
        }

        return $next($request);
    }

}
