<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemsRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\ServiceItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of items.
     *
     * @param Request $request
     * @return ItemCollection
     */
    public function index(Request $request)
    {
        $items = Item::query();

        // Filter the items
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'O': // Object
                case 'F': // Food
                    $items->where('type', $request->filter);
                    break;
                case 'room': // Room
                case 'bathroom': // Bathroom
                case 'drink': // Drink
                case 'breakfast': // Breakfast
                case 'lunch': // Lunch
                case 'dinner': // Dinner
                case 'snack': // Snack
                case 'other': // Other
                    $items->where('category', $request->filter);
                    break;
                case 'D': // Deleted
                    $items->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the items
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $items->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $items->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ItemResource::$format = 'simple';
        return ItemResource::collection($items->paginate(20));
    }

    /**
     * Display the specified item.
     *
     * @param int $id
     * @return ItemResource
     */
    public function show(int $id)
    {
        $item = Item::findOrFail($id);

        ItemResource::$format = 'detailed';
        return new ItemResource($item);
    }

    /**
     * Display the items of the specified service.
     *
     * @param int $id
     * @param Request $request
     * @return ItemResource
     */
    public function service(int $id, Request $request)
    {
        $service = Service::findOrFail($id);
        $serviceItems = ServiceItem::where('service_id', $service->id)->get();
        $items = Item::whereIn('id', $serviceItems->pluck('item_id'));

        // Filter the items
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'O': // Object
                case 'F': // Food
                    $items->where('type', $request->filter);
                    break;
                case 'room': // Room
                case 'bathroom': // Bathroom
                case 'drink': // Drink
                case 'breakfast': // Breakfast
                case 'lunch': // Lunch
                case 'dinner': // Dinner
                case 'snack': // Snack
                case 'other': // Other
                    $items->where('category', $request->filter);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the items
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $items->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $items->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ItemResource::$format = 'detailed';
        return ItemResource::collection($items->paginate(20));
    }

    /**
     * Display the items of the specified order.
     *
     * @param int $id
     * @param Request $request
     * @return ItemResource
     */
    public function order(int $id, Request $request)
    {
        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $items = Item::whereIn('id', $orderItems->pluck('item_id'));

        // Filter the items
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'O': // Object
                case 'F': // Food
                    $items->where('type', $request->filter);
                    break;
                case 'room': // Room
                case 'bathroom': // Bathroom
                case 'drink': // Drink
                case 'breakfast': // Breakfast
                case 'lunch': // Lunch
                case 'dinner': // Dinner
                case 'snack': // Snack
                case 'other': // Other
                    $items->where('category', $request->filter);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the items
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $items->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $items->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ItemResource::$format = 'detailed';
        return ItemResource::collection($items->paginate(20));
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  ItemRequest  $request
     * @return ItemResource
     */
    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());

        // Check if request has service_id and if it exists create the relationship
        if ($request->has('service_id') && ($request->service_id == 2 || $request->service_id == 3)) {
            ServiceItem::create([
                'service_id' => $request->service_id,
                'item_id' => $item->id,
            ]);
        }

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.item')]),
            'item' => new ItemResource($item),
        ], 201);
    }

    /**
     * Update the specified item in storage.
     *
     * @param  ItemRequest  $request
     * @param  int  $id
     * @return ItemResource
     */
    public function update(ItemRequest $request, int $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.item')]),
            'item' => new ItemResource($item),
        ]);
    }

    /**
     * Associate the specified item to the specified service
     *
     * @param  int  $id
     * @param  string  $service
     * @param  Request  $request
     * @return JsonResponse
     */
    public function associate(int $id, string $service, ItemsRequest $request)
    {
        $items = [];
        if ($request->has('items')) {
            $items = $request->items;
        } else {
            $items[] = $id;
        }

        $serviceItems = [];
        foreach ($items as $item) {
            $serviceItem = ServiceItem::where('item_id', $item)->where('service_id', $service)->first();

            // Check if the item is already associated to the service
            if ($serviceItem) {
                foreach ($serviceItems as $serviceItem) {
                    $serviceItem->delete();
                }
                return response()->json([
                    'message' => __('messages.already_associated', ['attribute' => $item]),
                ], 409);
            }

            // Check if the item is the same type as the service
            $item = Item::findOrFail($id);
            $serviceObj = Service::findOrFail($service);
            if (($item->type != $serviceObj->type) && ($serviceObj->type == 'B' && $item->type != 'O')) {
                foreach ($serviceItems as $serviceItem) {
                    $serviceItem->delete();
                }
                return response()->json([
                    'message' => __('messages.invalid_association', ['attribute' => $item]),
                ], 401);
            }

            $serviceItems[] = ServiceItem::create([
                'service_id' => $service,
                'item_id' => $item->id,
            ]);

            // Put the item active
            $item->active = true;
            $item->save();
        }

        if (count($items) > 1) {
            return response()->json([
                'message' => __('messages.associated', ['attribute' => __('messages.attributes.items')]),
            ]);
        } else {
            return response()->json([
                'message' => __('messages.associated', ['attribute' => __('messages.attributes.item')]),
            ]);
        }
    }

    /**
     * Disassociate the specified item from the specified service
     *
     * @param  int  $id
     * @param  string  $service
     * @return JsonResponse
     */
    public function disassociate(int $id, string $service)
    {
        $serviceItem = ServiceItem::where('item_id', $id)->where('service_id', $service)->first();

        // Check if the item is not associated to the service
        if (!$serviceItem) {
            return response()->json([
                'message' => __('messages.not_associated', ['attribute' => __('messages.attributes.item')]),
            ], 409);
        }

        $serviceItem->delete();

        // Put the item not active
        $item = Item::findOrFail($id);
        $item->active = false;
        $item->save();

        return response()->json([
            'message' => __('messages.disassociated', ['attribute' => __('messages.attributes.item')]),
        ]);
    }

    /**
     * Remove the specified item from storage.
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

        Item::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.item')]),
        ]);
    }
}
