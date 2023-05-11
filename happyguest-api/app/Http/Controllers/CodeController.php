<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\UserCode;
use App\Http\Resources\CodeResource;
use App\Http\Requests\CodeRequest;
use App\Http\Resources\UserCodeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteRequest;
use App\Models\User;

class CodeController extends Controller
{

    /**
     * Display a listing of the codes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        CodeResource::$format = 'simple';
        return CodeResource::collection(Code::paginate(20));
    }

    /**
     * Display the specified code.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        CodeResource::$format = 'detailed';
        return new CodeResource(Code::findOrFail($id));
    }

    /**
     * Display the specified user's codes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(int $id)
    {
        UserCodeResource::$format = 'code';
        return UserCodeResource::collection(UserCode::where('user_id', $id)->paginate(20));
    }

    /**
     * Associate the specified code to the specified user.
     *
     * @param  int  $id
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function associate(int $id, string $code)
    {
        $codeId = Code::where('code', $code)->firstOrFail()->id;

        $userCode = UserCode::where('user_id', $id)->where('code_id', $codeId)->first();

        // Check if code is already associated to the user
        if ($userCode) {
            return response()->json([
                'message' => __('messages.already_associated', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        $user = User::findOrFail($id);

        // Check if user is not a client
        if ($user->role != 'C') {
            return response()->json([
                'message' => __('messages.only_clients'),
            ], 401);
        }

        UserCode::create([
            'user_id' => $id,
            'code_id' => $codeId,
        ]);

        Code::findOrFail($codeId)->update([
            'used' => true,
        ]);

        return response()->json([
            'message' => __('messages.associated', ['attribute' => __('messages.attributes.code')]),
        ]);
    }

    /**
     * Disassociate the specified code from the specified user.
     *
     * @param  int  $id
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function disassociate(int $id, string $code)
    {
        $codeId = Code::where('code', $code)->firstOrFail()->id;

        $userCode = UserCode::where('user_id', $id)->where('code_id', $codeId)->first();

        // Check if code is not associated to the user
        if (!$userCode) {
            return response()->json([
                'message' => __('messages.not_associated', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        $userCode->delete();

        return response()->json([
            'message' => __('messages.disassociated', ['attribute' => __('messages.attributes.code')]),
        ]);
    }

    /**
     * Store a newly created code in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CodeRequest $request)
    {
        $code = Code::create($request->validated());

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.code')]),
            'code' => new CodeResource($code),
        ], 201);
    }

    /**
     * Update the specified code in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CodeRequest $request, int $id)
    {
        $code = Code::findOrFail($id);
        $code->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.code')]),
            'code' => new CodeResource($code),
        ]);
    }

    /**
     * Remove the specified code from storage.
     *
     * @param  DeleteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        Code::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.code')]),
        ]);
    }
}
