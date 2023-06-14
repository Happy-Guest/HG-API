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
use Illuminate\Http\Request;

class CodeController extends Controller
{
    /**
     * Display a listing of codes.
     *
     * @param Request $request
     * @return CodeCollection
     */
    public function index(Request $request)
    {
        $codes = Code::query();

        // Filter the codes
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'V': // Valid
                    $codes->where('exit_date', '>', date('Y-m-d H:i:s'))->where('entry_date', '<', date('Y-m-d H:i:s'));
                    break;
                case 'E': // Expired
                    $codes->where('exit_date', '<', date('Y-m-d H:i:s'));
                    break;
                case 'U': // Used
                    $codes->where('used', true);
                    break;
                case 'NU': // Not used
                    $codes->where('used', false);
                    break;
                case 'D': // Deleted
                    $codes->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the codes
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $codes->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $codes->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        CodeResource::$format = 'code';
        return CodeResource::collection($codes->paginate(20));
    }

    /**
     * Display the specified code.
     *
     * @param  int  $id
     * @return CodeResource
     */
    public function show(int $id)
    {
        CodeResource::$format = 'detailed';
        return new CodeResource(Code::findOrFail($id));
    }

    /**
     * Display the specified code's users.
     *
     * @param  int  $id
     * @return UserCodeCollection
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
     * @return JsonResponse
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

        // Check if the code is still valid
        if (Code::findOrFail($codeId)->exit_date < date('Y-m-d')) {
            return response()->json([
                'message' => __('messages.expired', ['attribute' => __('messages.attributes.code')]),
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
     * @return JsonResponse
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
     * Display the specified user's valid codes.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function valid_code(int $id)
    {
        $userCode = UserCode::where('user_id', $id)->first();

        // Check if user has a valid code
        $hasValidCode = false;
        foreach ($userCode as $code) {
            if ($code->exit_date >= now()) {
                $hasValidCode = true;
                break;
            }
        }

        return response()->json([
            'message' => __('messages.has_valid_code'),
            'hasValidCode' => $hasValidCode,
        ]);
    }

    /**
     * Store a newly created code in storage.
     *
     * @param  CodeRequest  $request
     * @return CodeResource
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
     * @param  CodeRequest  $request
     * @param  int  $id
     * @return CodeResource
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

        Code::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.code')]),
        ]);
    }
}
