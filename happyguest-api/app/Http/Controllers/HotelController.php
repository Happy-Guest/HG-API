<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Http\Requests\HotelRequest;
use App\Models\Hotel;

class HotelController extends Controller
{
    /**
     * Display information of hotel.
     *
     * @return HotelCollection
     */
    public function index()
    {
        return new HotelResource(Hotel::findOrFail(1));
    }

    /**
     * Update the information hotel in storage.
     *
     * @param  HotelRequest  $request
     * @return HotelResource
     */
    public function update(HotelRequest $request,)
    {
        $hotel = Hotel::findOrFail(1);

        if (auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        $hotel->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.hotel')]),
            'hotel' => new HotelResource($hotel),
        ]);
    }
}
