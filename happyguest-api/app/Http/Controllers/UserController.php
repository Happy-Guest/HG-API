<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCode;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Resources\UserCodeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return UserCollection
     */
    public function index(Request $request)
    {
        $users = User::query();

        // Filter the users
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'C': // Client
                case 'M': // Manager
                case 'A': // Admin
                    $users->where('role', $request->filter);
                    break;
                case 'NB': // Not blocked
                    $users->where('blocked', false);
                    break;
                case 'B': // Blocked
                    $users->where('blocked', true);
                    break;
                case 'D': // Deleted
                    $users->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the users
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $users->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $users->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        UserResource::$format = 'simple';
        return UserResource::collection($users->paginate(20));
    }

    /**
     * Display the specified user.
     *
     * @param int $id
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
     * @param string $role
     * @return UserResource
     */
    public function show_role(string $role)
    {
        UserResource::$format = 'simple';
        return UserResource::collection(User::where('role', $role)->paginate(20));
    }

    /**
     * Display the specified user's codes.
     *
     * @param int $id
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
     * @param int $id
     * @return UserResource
     */
    public function update(UserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        // Check if user has uploaded a photo (Base64)
        if ($request->has('photoBase64') && $request->photoBase64 != null) {
            // Delete old image
            if ($user->photo_url) {
                unlink(storage_path('app/public/user_photos/' . $user->photo_url));
            }
            $image = $request->photoBase64;
            $image_name = $user->id . "_" . uniqid() . '.jpg';
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image_data = base64_decode($image);
            file_put_contents(storage_path('app/public/user_photos') . '/' . $image_name, $image_data);
            $user->photo_url = $image_name;
            $user->update();
        }

        // Check if user has uploaded a image
        if ($request->hasFile('photo')) {
            // Delete old image
            if ($user->photo_url) {
                unlink(storage_path('app/public/user_photos/' . $user->photo_url));
            }
            $image = $request->file('photo');
            $image_name = $user->id . "_" . uniqid() . '.jpg';
            $image->move(storage_path('app/public/user_photos'), $image_name);
            $user->photo_url = $image_name;
            $user->update();
        }

        $user->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Update the specified user in storage. (Block)
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function block(int $id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update(['blocked' => true]);

        // Check if user is blocking himself
        if ($user->id == Auth::user()->id) {
            $request->user()->token()->revoke();
        }

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.user')]),
        ]);
    }

    /**
     * Update the specified user in storage. (Unblock)
     *
     * @param int $id
     * @return JsonResponse
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
     * @param DeleteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, int $id)
    {
        // Check if password is correct
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'errors' => [
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
