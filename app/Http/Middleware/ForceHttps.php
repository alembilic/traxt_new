<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request Request to force https redirection
     * @param Closure $next Next middleware in the chain
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('local') && !$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
