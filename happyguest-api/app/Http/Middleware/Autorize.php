<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Autorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admins can access everything
        if (auth()->user()->role == 'A') {
            return $next($request);
        }

        // Users can't access other users except Managers
        if ($request->route('id') != auth()->id() && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 403);
        }

        // Managers can't access Admins
        $user = User::findOrfail($request->route('id'));
        if ($user->role == 'A' && auth()->user()->role == 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 403);
        }

        return $next($request);
    }
}
