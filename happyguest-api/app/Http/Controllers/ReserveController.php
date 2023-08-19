<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Service;
use App\Http\Resources\ReserveResource;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\DeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\FCMService;

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

        // Filter the reserves
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'OR': // Restaurant
                    $reserves->whereHas('service', function ($query) {
                        $query->where('type', 'R');
                    });
                    break;
                case 'O': // Others
                    $reserves->whereHas('service', function ($query) {
                        $query->where('type', 'O');
                    });
                    break;
                case 'P': // Pending
                case 'A': // Accepted
                case 'R': // Rejected
                case 'F': // Finished
                case 'C': // Cancelled
                    $reserves->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $reserves->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the reserves
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $reserves->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $reserves->orderBy('id', 'desc');
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
        if ($reserve->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M' && auth()->user()->role != 'E') {
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
     * @param Request $request
     * @return ReserveResource
     */
    public function user(int $id, Request $request)
    {
        $reserves = Reserve::where('user_id', $id);

        // Filter the reserves
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'OR': // Restaurant
                    $reserves->whereHas('service', function ($query) {
                        $query->where('type', 'R');
                    });
                    break;
                case 'O': // Others
                    $reserves->whereHas('service', function ($query) {
                        $query->where('type', 'O');
                    });
                    break;
                case 'P': // Pending
                case 'A': // Accepted
                case 'R': // Rejected
                case 'F': // Finished
                case 'C': // Cancelled
                    $reserves->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $reserves->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the reserves
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $reserves->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $reserves->orderBy('id', 'desc');
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
     * Store a newly created reserve in storage.
     *
     * @param  ReserveRequest  $request
     * @return ReserveResource
     */
    public function store(ReserveRequest $request)
    {
        $service = Service::findOrFail($request->service_id);

        // Check if limit of reserves per hour is reached
        if ($service->limit) {
            $reserves = Reserve::where('service_id', $request->service_id)
                ->where('time', '>=', date('Y/m/d H:i', strtotime($request->time) - 3600))
                ->count();

            if ($reserves >= $service->limit) {
                return response()->json([
                    'message' => __('messages.service_limit_reached'),
                ], 400);
            }
        }

        $reserve = Reserve::create($request->validated());

        // Send notification to admins, managers and employees
        $notification = [
            'title' => __('messages.new_reservation', ['id' => $reserve->id, 'time' => $reserve->time->format('d/m/Y H:i')]),
            'body' => __('messages.new_reservation', ['id' => $reserve->id, 'time' => $reserve->time->format('d/m/Y H:i')]),
        ];

        $admins = User::where('role', 'A')->get();
        foreach ($admins as $admin) {
            if ($admin->fcm_token) {
                FCMService::send($admin->fcm_token, $notification);
            }
        }

        $managers = User::where('role', 'M')->get();
        foreach ($managers as $manager) {
            if ($manager->fcm_token) {
                FCMService::send($manager->fcm_token, $notification);
            }
        }

        $employees = User::where('role', 'E')->get();
        foreach ($employees as $employee) {
            if ($employee->fcm_token) {
                FCMService::send($employee->fcm_token, $notification);
            }
        }

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
        if (Reserve::findOrFail($id)->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M' && auth()->user()->role != 'E') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        $reserve->update($request->validated());

        // Send notification to user
        if ($reserve->user->fcm_token) {
            $notification = [
                'title' => __('messages.response_reservation', ['time' => $reserve->time->format('d/m/Y H:i')]),
                'body' => __('messages.response_reservation', ['time' => $reserve->time->format('d/m/Y H:i')]),
            ];

            FCMService::send($reserve->user->fcm_token, $notification);
        }

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
