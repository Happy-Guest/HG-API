<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use App\Models\ComplaintFile;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the Complaints.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complaints = Complaint::query();

        // Filter the complaints
        if (request()->has('filter') && request()->filter != 'ALL') {
            switch (request()->filter) {
                case 'P': // Pending
                case 'S': // Solving
                case 'R': // Resolved
                case 'C': // Cancelled
                    $complaints->where('status', request()->filter);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the complaints
        if (request()->has('order') ) {
            switch (request()->order) {
                case 'ASC': // Ascending
                    $complaints->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $complaints->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ComplaintResource::$format = 'simple';
        return ComplaintResource::collection($complaints->paginate(20));
    }

    /**
     * Display the specified Complaint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Check if authenticated user is the same as the complaint's user
        if ($complaint->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        ComplaintResource::$format = 'detailed';
        return new ComplaintResource($complaint);
    }

    /**
     * Display the specified user's Complaints.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(int $id)
    {
        ComplaintResource::$format = 'simple';
        return ComplaintResource::collection(Complaint::where('user_id', $id)->paginate(20));
    }

    /**
     * Display the specified Complaint's files.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function file(int $id, int $file)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint_file = ComplaintFile::where('complaint_id', $id)->where('id', $file)->firstOrFail();

        // Check if authenticated user is the same as the complaint's user
        if ($complaint->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        return response()->file(storage_path('app/complaint_files/' . $complaint->id . '/' . $complaint_file->filename));
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

        // Store files
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(storage_path('app/complaint_files/' . $complaint->id . '/'), $filename);
                ComplaintFile::create([
                    'complaint_id' => $complaint->id,
                    'filename' => $filename,
                ]);
            }
        }

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.complaint')]),
            'complaint' => new ComplaintResource($complaint),
        ], 201);
    }

    /**
     * Update the specified complaint in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComplaintRequest $request, int $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update($request->validated());

        return response()->json([
            'message' => __('messages.updated2', ['attribute' => __('messages.attributes.complaint')]),
            'complaint' => new ComplaintResource($complaint),
        ]);
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
            'message' => __('messages.deleted2', ['attribute' => __('messages.attributes.complaint')]),
        ]);
    }

}
