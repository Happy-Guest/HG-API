<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // If the user is an Admin, allow access
        if (auth()->user()->role == 'A') {
            return $next($request);
        }

        // If the role is Employee, allow access to Managers and Employees
        if ($role == 'E' && (auth()->user()->role == 'M' || auth()->user()->role == 'E')) {
            return $next($request);
        }

        // If the role is Manager, allow access to Managers
        if ($role == 'M' && auth()->user()->role == 'M') {
            return $next($request);
        }

        // If the role is Client, allow access to Clients
        if ($role == 'C' && auth()->user()->role == 'C') {
            return $next($request);
        }

        return $next($request);
    }
}
