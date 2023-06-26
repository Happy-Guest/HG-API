<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Http\Resources\ReserveResource;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\DeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    /**
     * Display a listing of reserves.
     *
     * @param Request $request
     * @return ReserveCollection
     */
    public function index(Request $request)
    {
        $reserves = Reserve::query();

        // reserve the reserves
        if ($request->has('reserve')) {
            switch ($request->reserve) {
                case 'ASC': // Ascending
                    $reserves->reserveBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $reserves->reserveBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ReserveResource::$format = 'simple';
        return ReserveResource::collection($reserves->paginate(20));
    }

    /**
     * Display the specified reserve.
     *
     * @param int $id
     * @return ReserveResource
     */
    public function show(int $id)
    {
        $reserve = Reserve::findOrFail($id);

        // Check if authenticated user is the same as the reserve's user
        if ($reserve->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        ReserveResource::$format = 'detailed';
        return new ReserveResource($reserve);
    }

    /**
     * Display the user's reserves.
     *
     * @param int $id
     * @return ReserveResource
     */
    public function user(int $id)
    {
        $reserves = Reserve::where('user_id', $id)->get();

        ReserveResource::$format = 'simple';
        return ReserveResource::collection($reserves);
    }

    /**
     * Store a newly created reserve in storage.
     *
     * @param  ReserveRequest  $request
     * @return ReserveResource
     */
    public function store(ReserveRequest $request)
    {

        $reserve = Reserve::create($request->validated());

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.reserve')]),
            'reserve' => new ReserveResource($reserve),
        ], 201);
    }

    /**
     * Update the specified reserve in storage.
     *
     * @param  ReserveRequest  $request
     * @param  int  $id
     * @return ReserveResource
     */
    public function update(ReserveRequest $request, int $id)
    {
        $reserve = Reserve::findOrFail($id);

        // Check if authenticated user is the same as the reserve's user
        if (Reserve::findOrFail($id)->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        $reserve->update($request->validated());

        return response()->json([
            'message' => __('messages.updated2', ['attribute' => __('messages.attributes.reserve')]),
            'reserve' => new ReserveResource($reserve),
        ]);
    }

    /**
     * Remove the specified reserve from storage.
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

        Reserve::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted2', ['attribute' => __('messages.attributes.reserve')]),
        ]);
    }
}
