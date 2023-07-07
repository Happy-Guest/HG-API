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
        return HotelResource::collection(Hotel::all());
    }

    /**
     * Display information of hotel.
     *
     * @param  int  $id
     * @return HotelResource
     */
    public function show(int $id)
    {
        return new HotelResource(Hotel::findOrFail($id));
    }

    /**
     * Store a newly created hotel in storage.
     *
     * @param  HotelRequest  $request
     * @return HotelResource
     */
    public function store(HotelRequest $request)
    {
        $hotel = Hotel::create($request->validated());

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.hotel')]),
            'hotel' => new HotelResource($hotel),
        ]);
    }

    /**
     * Update the information hotel in storage.
     *
     * @param  HotelRequest  $request
     * @return HotelResource
     */
    public function update(HotelRequest $request)
    {
        $hotel = Hotel::findOrFail(1);

        $hotel->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.hotel')]),
            'hotel' => new HotelResource($hotel),
        ]);
    }
}
