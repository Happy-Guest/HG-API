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
use Carbon\Carbon;
use App\Mail\ShareCodeMail;
use Illuminate\Support\Facades\Mail;

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
                    $codes->where('exit_date', '>=', date('Y-m-d'))
                        ->where('entry_date', '<=', date('Y-m-d'));
                    $codes->whereDoesntHave('checkout');
                    break;
                case 'E': // Expired
                    $codes->where('exit_date', '<', date('Y-m-d'));
                    break;
                case 'C': // Checked out
                    $codes->whereHas('checkout', function ($query) {
                        $query->where('validated', true);
                    });
                    break;
                case 'IC': // In checked out
                    $codes->whereHas('checkout', function ($query) {
                        $query->where('validated', false);
                    });
                    break;
                case 'NC': // Not checked out
                    $codes->whereDoesntHave('checkout');
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

        CodeResource::$format = 'simple';
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
     * @param Request $request
     * @return UserCodeCollection
     */
    public function user(int $id, Request $request)
    {
        $userCodes = UserCode::where('user_id', $id);

        // Filter the user codes
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'V': // Valid
                    $userCodes->whereHas('code', function ($query) {
                        $query->where('exit_date', '>=', date('Y-m-d'))
                            ->where('entry_date', '<=', date('Y-m-d'));
                    });
                    $userCodes->whereDoesntHave('code.checkout');
                    break;
                case 'C': // Checked out
                    $userCodes->whereHas('code.checkout', function ($query) {
                        $query->where('validated', true);
                    });
                    break;
                case 'IC': // In checked out
                    $userCodes->whereHas('code.checkout', function ($query) {
                        $query->where('validated', false);
                    });
                    break;
                case 'NC': // Not checked out
                    $userCodes->whereDoesntHave('code.checkout');
                    break;
                case 'E': // Expired
                    $userCodes->whereHas('code', function ($query) {
                        $query->where('exit_date', '<', date('Y-m-d'));
                    });
                    break;
                case 'U': // Used
                    $userCodes->whereHas('code', function ($query) {
                        $query->where('used', true);
                    });
                    break;
                case 'NU': // Not used
                    $userCodes->whereHas('code', function ($query) {
                        $query->where('used', false);
                    });
                    break;
                case 'D': // Deleted
                    $userCodes->whereHas('code', function ($query) {
                        $query->whereNotNull('deleted_at')->withTrashed();
                    });
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the user codes
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $userCodes->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $userCodes->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        UserCodeResource::$format = 'code';
        return UserCodeResource::collection($userCodes->paginate(20));
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
        $code = Code::where('code', $code)->firstOrFail();

        $userCode = UserCode::where('user_id', $id)->where('code_id', $code->id)->first();

        // Check if code is already associated to the user
        if ($userCode) {
            return response()->json([
                'message' => __('messages.already_associated', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        $entryDate = Carbon::parse($code->entry_date)->setTimezone('Europe/lisbon')->toDateString();
        $exitDate = Carbon::parse($code->exit_date)->setTimezone('Europe/lisbon')->toDateString();

        // Check if the code is still valid
        if ($exitDate < date('Y-m-d')) {
            return response()->json([
                'message' => __('messages.expired', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        // Check if the code is not yet valid
        if ($entryDate > date('Y-m-d')) {
            return response()->json([
                'message' => __('messages.not_yet_valid', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        // Check if the code is in checkout and validated
        if ($code->checkout && $code->checkout->validated) {
            return response()->json([
                'message' => __('messages.checked_out', ['attribute' => __('messages.attributes.code')]),
            ], 409);
        }

        // Check if the code is in checkout and not validated
        if ($code->checkout && !$code->checkout->validated) {
            return response()->json([
                'message' => __('messages.in_checkout', ['attribute' => __('messages.attributes.code')]),
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
            'code_id' => $code->id,
        ]);

        Code::findOrFail($code->id)->update([
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
     * @param Request $request
     * @return JsonResponse
     */
    public function valid_code(Request $request)
    {
        $userCodes = UserCode::where('user_id', $request->user()->id)->get();

        // Check if user has a valid code
        $hasValidCode = false;
        if ($userCodes) {
            foreach ($userCodes as $userCode) {
                $entryDate = Carbon::parse($userCode->code->entry_date)->setTimezone('Europe/lisbon')->toDateString();
                $exitDate = Carbon::parse($userCode->code->exit_date)->setTimezone('Europe/lisbon')->toDateString();
                if ($entryDate <= date('Y-m-d') && $exitDate >= date('Y-m-d')) {
                    // Check if code has a checkout
                    if (!$userCode->code->checkout) {
                        $hasValidCode = true;
                        break;
                    }
                }
            }
        }

        return response()->json([
            'message' => $hasValidCode ? __('messages.has_valid_code') : __('messages.has_not_valid_code'),
            'validCode' => $hasValidCode,
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

        // Send email with code if email is received
        if ($request->email) {
            Mail::to($request->email)->send(new ShareCodeMail($code));
        }

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
