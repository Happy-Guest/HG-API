<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\DeleteRequest;
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

        // Order the orders
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

        // Check if authenticated user is the same as the item's user
        if ($item->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        ItemResource::$format = 'detailed';
        return new ItemResource($item);
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

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.item')]),
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
            'message' => __('messages.updated2', ['attribute' => __('messages.attributes.item')]),
            'item' => new ItemResource($item),
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
            'message' => __('messages.deleted2', ['attribute' => __('messages.attributes.item')]),
        ]);
    }
}
