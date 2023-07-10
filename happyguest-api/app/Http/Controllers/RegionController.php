<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegionResource;
use App\Http\Requests\RegionRequest;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Display information of region.
     * 
     * @return RegionCollection
     */
    public function index()
    {
        return RegionResource::collection(Region::all());
    }

    /**
     * Display information of region.
     * 
     * @param  int  $id
     * @return RegionResource
     */
    public function show(int $id)
    {
        return new RegionResource(Region::findOrFail($id));
    }

    /**
     * Store a newly created region in storage.
     * 
     * @param  RegionRequest  $request
     * @return RegionResource
     */
    public function store(RegionRequest $request)
    {
        $region = Region::create($request->validated());

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.region')]),
            'region' => new RegionResource($region),
        ]);
    }

    /**
     * Update the information region in storage.
     * 
     * @param  RegionRequest  $request
     * @param  int  $id
     * @return RegionResource
     */
    public function update(RegionRequest $request, int $id)
    {
        $region = Region::findOrFail($id);

        $region->update($request->validated());

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.region')]),
            'region' => new RegionResource($region),
        ]);
    }
}
