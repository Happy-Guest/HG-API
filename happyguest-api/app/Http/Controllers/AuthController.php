<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        $user->save();

        return response()->json([
            'message' => __('auth.registered'),
        ], 201);
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $credentials = request(['email', 'password']);

        // Check if combination of email and password is correct
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => __('auth.password'),
            ], 401);
        }

        $user = $request->user();

        // Check if user is a client and is not using a mobile device
        if ($user->role == 'C' && $request->device != 'mobile') {
            return response()->json([
                'message' => __('auth.unauthorized'),
            ], 401);
        }

        // Check if user is blocked
        if ($user->blocked) {
            Auth::logout();
            return response()->json([
                'message' =>
                __('auth.blocked'),
            ], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'message' => __('auth.logged_in'),
        ]);
    }

    /**
     * Logout a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => __('auth.logged_out'),
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Change the authenticated user's password.
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change_password(ChangePasswordRequest $request)
    {
        $request->validated();

        $user = $request->user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => __('auth.password'),
            ], 401);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => __('auth.password_changed'),
        ]);
    }
}
