<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCode;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCodeResource;

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
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(int $id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.user')]),
        ]);
    }
}
