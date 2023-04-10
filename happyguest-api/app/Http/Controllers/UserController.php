<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

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
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function update(UserRequest $request)
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
        ]);
    }
}
