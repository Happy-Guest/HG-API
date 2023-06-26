<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\DeleteRequest;
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
     * @return OrderResource
     */
    public function user(int $id)
    {
        $orders = Order::where('user_id', $id)->get();

        OrderResource::$format = 'simple';
        return OrderResource::collection($orders);
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
