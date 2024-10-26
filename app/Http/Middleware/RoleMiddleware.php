<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            abort(401, "Unauthenticated");
        }

        if (!auth()->user()->roles()->where('name', $role)->exists()) {
            abort(403, "You don't have permission");
        }

        return $next($request);
    }
}
