<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register a new user (Mobile)
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => 'C',
        ]);

        $user->save();

        // Check if user has uploaded a photo (Base64)
        if ($request->has('photoBase64') && $request->photoBase64 != null) {
            $image = $request->photoBase64;
            $image_name = $user->id . "_" . uniqid() . '.jpg';
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image_data = base64_decode($image);
            file_put_contents(storage_path('app/public/user_photos') . '/' . $image_name, $image_data);
            $user->photo_url = $image_name;
            $user->update();
        }

        // Check if user has uploaded a photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = $user->id . "_" . uniqid() . '.jpg';
            $image->move(storage_path('app/public/user_photos'), $image_name);
            $user->photo_url = $image_name;
            $user->update();
        }

        return response()->json([
            'message' => __('auth.registered'),
        ], 201);
    }

    /**
     * Register a new user. (Dashboard)
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register_team(RegisterRequest $request)
    {
        $request->validated();

        // Check if user is trying to register as a Manager or Admin
        if (($request->role == 'A' && Auth::user()->role != 'A') || ($request->role == 'M' && Auth::user()->role != 'A')) {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'role' => $request->role,
        ]);

        $user->save();

        // Check if user has uploaded a photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = $user->id . "_" . uniqid() . '.jpg';
            $image->move(storage_path('app/public/user_photos'), $image_name);
            $user->photo_url = $image_name;
            $user->update();
        }

        return response()->json([
            'message' => __('auth.registered'),
        ], 201);
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        // Check if user exists
        if (!User::where('email', $request->email)->first()) {
            return response()->json([
                'message' => __('auth.email'),
                'errors' => [
                    'email' => [__('auth.email')],
                ],
            ], 401);
        }

        $credentials = request(['email', 'password']);

        // Check if combination of email and password is correct
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => __('auth.password'),
                'errors' => [
                    'password' => [__('auth.password')],
                ],
            ], 401);
        }

        $user = $request->user();

        // Check if user is a client and is not using a mobile device
        if ($user->role == 'C' && $request->device != 'mobile') {
            return response()->json([
                'message' => __('auth.unauthorized'),
            ], 401);
        }

        // Check if user is a manager or admin and is using a mobile device
        if (($user->role == 'M' || $user->role == 'A') && $request->device == 'mobile') {
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Change the authenticated user password.
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function change_password(ChangePasswordRequest $request)
    {
        $request->validated();

        // Check if its reset password request
        if ($request->has('user_id') && $request->user_id != null && Auth::user()->role == 'A') {
            $user = User::find($request->user_id);
            $user->password = bcrypt('123456789');
            $user->save();

            return response()->json([
                'message' => __('auth.password_changed'),
            ]);
        }

        $user = $request->user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'errors' => [
                    'old_password' => [
                        __('auth.password'),
                    ],
                ],
            ], 401);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => __('auth.password_changed'),
        ]);
    }
}
