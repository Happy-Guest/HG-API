<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\Service;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Services\FCMService;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @param Request $request
     * @return OrderCollection
     */
    public function index(Request $request)
    {
        $orders = Order::query();

        // Filter the orders
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'OC': // Cleaning
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'C');
                    });
                    break;
                case 'OB': // Objects
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'B');
                    });
                    break;
                case 'OF': // Foods
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'F');
                    });
                    break;
                case 'O': // Others
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'O');
                    });
                    break;
                case 'P': // Pending
                case 'R': // Rejected
                case 'W': // Working
                case 'C': // Canceled
                case 'DL': // Delivered
                    $orders->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $orders->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the orders
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $orders->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $orders->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        // Search the orders by name of user
        if ($request->has('search')) {
            $orders->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        OrderResource::$format = 'simple';
        return OrderResource::collection($orders->paginate(20));
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return OrderResource
     */
    public function show(int $id)
    {
        $order = Order::findOrFail($id);

        // Check if authenticated user is the same as the order's user
        if ($order->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M' && auth()->user()->role != 'E') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        OrderResource::$format = 'detailed';
        return new OrderResource($order);
    }

    /**
     * Display the user's orders.
     *
     * @param int $id
     * @param Request $request
     * @return OrderCollection
     */
    public function user(int $id, Request $request)
    {
        $orders = Order::where('user_id', $id);

        // Filter the orders
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'OC': // Cleaning
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'C');
                    });
                    break;
                case 'OB': // Objects
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'B');
                    });
                    break;
                case 'OF': // Foods
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'F');
                    });
                    break;
                case 'O': // Others
                    $orders->whereHas('service', function ($query) {
                        $query->where('type', 'O');
                    });
                    break;
                case 'P': // Pending
                case 'R': // Rejected
                case 'W': // Working
                case 'DL': // Delivered
                case 'C': // Canceled
                    $orders->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $orders->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the orders
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $orders->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $orders->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        OrderResource::$format = 'simple';
        return OrderResource::collection($orders->paginate(20));
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  OrderRequest  $request
     * @return OrderResource
     */
    public function store(OrderRequest $request)
    {
        $service = Service::findOrFail($request->service_id);

        // Check if limit of reserves per hour is reached
        if ($service->limit) {
            $orders = Order::where('service_id', $request->service_id)
                ->where('time', '>=', date('Y/m/d H:i', strtotime($request->time) - 3600))
                ->count();

            if ($orders >= $service->limit) {
                return response()->json([
                    'message' => __('messages.service_limit_reached'),
                ], 400);
            }
        }

        $order = Order::create($request->validated());

        // Create the order items
        if ($request->has('items') && $request->items != null) {
            $orderItems = [];
            foreach ($request->items as $requestItem) {
                $orderItems[] = new OrderItem([
                    'order_id' => $order->id,
                    'item_id' => $requestItem['id'],
                    'quantity' => $requestItem['quantity'],
                ]);

                // Check if the item has stock
                $item = Item::findOrFail($requestItem['id']);
                if ($item->stock != null) {
                    if ($item->stock < $requestItem['quantity']) {
                        // Rollback the order creation and the order items
                        $order->delete();
                        foreach ($orderItems as $orderItem) {
                            $orderItem->delete();
                        }
                        return response()->json([
                            'message' => __('messages.out_of_stock', ['attribute' => $item->name]),
                        ], 400);
                    }
                }
            }

            // Update the stock of the items
            foreach ($orderItems as $orderItem) {
                $item = Item::findOrFail($orderItem->item_id);
                if ($item->stock != null) {
                    $item->stock -= $orderItem->quantity;
                    $item->save();
                }
            }

            // Save the order items
            foreach ($orderItems as $orderItem) {
                $orderItem->save();
            }
        }

        // Check for order time
        if ($order->time === null) {
            $order->time = Carbon::parse($order->created_at)->format('Y/m/d H:i');
            $order->save();
        }

        // Send notification to admins, managers and employees
        $notification = [
            'title' => __('messages.leiria_hotel'),
            'body' => __('messages.new_order', ['id' => $order->id, 'time' => $order->time->format('d/m/Y H:i')]),
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
            'message' => __('messages.created', ['attribute' => __('messages.attributes.order')]),
            'order' => new OrderResource($order),
        ], 201);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  OrderRequest  $request
     * @param  int  $id
     * @return OrderResource
     */
    public function update(OrderRequest $request, int $id)
    {
        $order = Order::findOrFail($id);

        // Check if authenticated user is the same as the order's user
        if (Order::findOrFail($id)->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M' && auth()->user()->role != 'E') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        $order->update($request->validated());

        // Update the stock of the items
        if (($order->status == 'C' || $order->status == 'D') && $order->orderItems != null) {
            foreach ($order->orderItems as $orderItem) {
                $item = Item::findOrFail($orderItem->item_id);
                if ($item->stock != null) {
                    $item->stock += $orderItem->quantity;
                    $item->save();
                }
            }
        }

        // Send notification to user
        if ($order->user && $order->user->fcm_token) {
            $notification = [
                'title' => __('messages.leiria_hotel'),
                'body' => __('messages.response_order', ['time' => $order->time->format('d/m/Y H:i')]),
            ];

            FCMService::send($order->user->fcm_token, $notification);
        }

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.order')]),
            'order' => new OrderResource($order),
        ]);
    }

    /**
     * Remove the specified order from storage.
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

        Order::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.order')]),
        ]);
    }
}
