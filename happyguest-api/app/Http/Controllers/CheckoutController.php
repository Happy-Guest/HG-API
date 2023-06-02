<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteRequest;

class CheckoutController extends Controller
{
    /**
     * Display a listing of checkouts.
     *
     * @param Request $request
     * @return CheckoutCollection
     */
    public function index(Request $request)
    {
        $checkouts = Checkout::query();

        // Filter the checkouts
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'V': // Valid
                    $checkouts->where('validated', true);
                    break;
                case 'NV': // Not valid
                    $checkouts->where('validated', false);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the checkouts
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $checkouts->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $checkouts->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        CheckoutResource::$format = 'simple';
        return CheckoutResource::collection($checkouts->paginate(20));
    }

    /**
     * Display the specified checkout.
     *
     * @param  int  $id
     * @return CheckoutResource
     */
    public function show(int $id)
    {
        $checkout = Checkout::findOrFail($id);

        // Check if the user is authorized to view the checkout
        if ($checkout->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        CheckoutResource::$format = 'detailed';
        return new CheckoutResource($checkout);
    }

    /**
     * Display the specified user's checkouts.
     *
     * @param  int  $id
     * @return CheckoutCollection
     */
    public function user(int $id)
    {
        CheckoutResource::$format = 'simple';
        return CheckoutResource::collection(CheckOut::where('user_id', $id)->paginate(20));
    }

    /**
     * Update the specified checkout in storage. (Validate)
     *
     * @param int $id
     * @return CheckoutResource
     */
    public function updateValidate(int $id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->update(['validated' => true]);

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.checkout')]),
        ]);
    }
    /**
     * Store a newly created checkout in storage.
     *
     * @param CheckoutRequest $request
     * @return CheckoutResource
     */
    public function store(CheckoutRequest $request)
    {
        $request->validated();

        // Check if the user is a customer
        $user = User::findOrFail($request->user_id);
        if ($user->role != 'C') {
            return response()->json([
                'errors' => [
                    'user_id' => [
                        __('messages.invalid_user'),
                    ],
                ],
            ], 400);
        }

        // Check if the code has already been checked out
        if (Checkout::where('code_id', $request->code_id)->exists()) {
            return response()->json([
                'message' => __('messages.checked_out'),
            ], 400);
        }

        $checkout = Checkout::create($request->validated());

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.checkout')]),
            'checkout' => new CheckoutResource($checkout),
        ], 201);
    }

    /**
     * Remove the specified checkout from storage.
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

        Checkout::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.checkout')]),
        ]);
    }
}
