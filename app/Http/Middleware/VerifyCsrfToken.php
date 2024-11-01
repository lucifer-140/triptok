<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken
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
        // If the request is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        // Verify CSRF token for non-AJAX requests
        if ($this->isReading($request) || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        if ($this->isReading($request) || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        if ($request->session()->token() !== $request->input('_token')) {
            throw new TokenMismatchException;
        }

        return $next($request);
    }

    protected function isReading($request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    protected function shouldPassThrough($request)
    {
        $except = [
            // Add URIs here that should be excluded from CSRF verification
        ];

        foreach ($except as $uri) {
            if ($request->is($uri)) {
                return true;
            }
        }

        return false;
    }
}
