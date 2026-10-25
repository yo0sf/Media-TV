<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', __('app.must_login_notice'));
        }

        $user = auth()->user();

        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Unauthorized access to Administrator panel.');
        }

        if ($role === 'manager' && !$user->isManager()) {
            abort(403, 'Unauthorized access to Manager portal.');
        }

        return $next($request);
    }
}
