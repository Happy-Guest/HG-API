<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        if ($order->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
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
     * @return OrderResource
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
        return OrderResource::collection($orders)->paginate(20);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  OrderRequest  $request
     * @return OrderResource
     */
    public function store(OrderRequest $request)
    {
        $order = Order::create($request->validated());

        // Create the order items
        if ($request->has('items')) {
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
            $order->items()->saveMany($orderItems);
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
        if (Order::findOrFail($id)->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
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
