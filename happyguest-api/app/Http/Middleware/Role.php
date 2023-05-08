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
        // Verify if the user is authorized to access the route except for Admins
        if (auth()->user()->role !== $role && auth()->user()->role !== 'A') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 403);
        }

        return $next($request);
    }
}
