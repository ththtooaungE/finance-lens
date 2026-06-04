<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FalseStatusUserCanNotCreateRecords
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_active) {
            return back()->with('error', 'Your account is inactive. Temporarily cannot create records. Please contact support.');
            // abort(403, 'Your account is inactive. Please contact support.');
        }
        return $next($request);
    }
}
