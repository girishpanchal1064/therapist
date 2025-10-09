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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has any of the required roles (case-insensitive)
        $userRoles = $user->roles->pluck('name')->map(function($role) {
            return strtolower($role);
        })->toArray();

        $requiredRoles = array_map('strtolower', $roles);

        if (!array_intersect($userRoles, $requiredRoles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
