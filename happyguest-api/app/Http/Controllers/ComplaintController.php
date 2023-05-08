<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the Complaints.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ComplaintResource::$format = 'simple';
        return ComplaintResource::collection(Complaint::paginate(20));
    }

    /**
     * Display the specified Complaint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) // Complaint $complaint  
    {
        ComplaintResource::$format = 'detailed';
        return new ComplaintResource(Complaint::findOrFail($id));
    }

    /**
     * Store a newly created complaint in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplaintRequest $request)
    {
        $complaint = Complaint::create($request->validated());

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.complaint')]),
            'code' => new ComplaintResource($complaint),
        ], 201);
    }

    /**
     * Remove the specified complaint from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Complaint::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.complaint')]),
        ]);
    }

}
