<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserCode;
use App\Models\Code;

class ValidCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role == 'A' || $request->user()->role == 'M') {
            return $next($request);
        }

        // Get all user codes
        $userCodes = UserCode::where('user_id', $request->user()->id)->get();

        // Check if user has a valid code
        $hasValidCode = false;
        if ($userCodes) {
            foreach ($userCodes as $userCode) {
                if (Code::findOrFail($userCode->code_id)->exit_date > date('Y-m-d')) {
                    $hasValidCode = true;
                    break;
                }
            }
        }

        // Verify if the user is authorized to access the route except for Admins
        if (!$hasValidCode) {
            return response()->json([
                'message' => __('messages.has_not_valid_code'),
            ], 403);
        }

        return $next($request);
    }
}
