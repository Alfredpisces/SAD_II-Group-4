<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
{
    // This allows the specific role OR any admin to pass
$userRole = strtolower($request->user()?->role ?? '');
    if (!$request->user() || ($userRole !== strtolower($role) && $userRole !== 'admin')) {
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
}
