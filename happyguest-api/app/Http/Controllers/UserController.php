<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCode;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Resources\UserCodeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return UserCollection
     */
    public function index()
    {
        UserResource::$format = 'simple';
        return UserResource::collection(User::paginate(20));
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(int $id)
    {
        UserResource::$format = 'detailed';
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Display a listing of blocked users.
     *
     * @param User $user
     * @return UserResource
     */
    public function show_blocked()
    {
        UserResource::$format = 'simple';
        return UserResource::collection(User::where('blocked', true)->paginate(20));
    }

    /**
     * Display a listing of unblocked users.
     *
     * @param User $user
     * @return UserResource
     */
    public function show_unblocked()
    {
        UserResource::$format = 'simple';
        return UserResource::collection(User::where('blocked', false)->paginate(20));
    }

    /**
     * Display a listing of users with the specified role.
     *
     * @param User $user
     * @return UserResource
     */
    public function show_role(string $role)
    {
        UserResource::$format = 'simple';
        return UserResource::collection(User::where('role', $role)->paginate(20));
    }

    /**
     * Display the specified code's users.
     *
     * @param User $user
     * @return UserCodeCollection
     */
    public function code(int $id)
    {
        UserCodeResource::$format = 'user';
        return UserCodeResource::collection(UserCode::where('code_id', $id)->paginate(20));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function update(UserRequest $request, int $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function block(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['blocked' => true]);

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function unblock(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['blocked' => false]);

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
        ]);
    }

    /**
     * Remove the specified user from storage.
    *
    * @param DeleteUserRequest $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(DeleteUserRequest $request, int $id)
    {
        // Check if password is correct
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['errors' => [
                'password' => [
                        __('auth.password'),
                    ],
                ],
            ], 401);
        }

        User::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.user')]),
        ]);
    }
}
