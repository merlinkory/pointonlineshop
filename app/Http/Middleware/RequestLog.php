<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        if (!in_array($path, config('constants.request_log_excludes', []))) {
            Log::info("Request (" . $request->method() . "): '$path'", $request->all());
        }
        return $next($request);
    }
}
