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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized access');
        }

        // Check if seller is approved
        if ($role === 'seller' && auth()->user()->status !== 'approved') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your seller account is pending approval');
        }

        return $next($request);
    }
}
