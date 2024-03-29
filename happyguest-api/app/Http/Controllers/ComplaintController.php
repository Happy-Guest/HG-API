<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use App\Models\ComplaintFile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\DeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\FCMService;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints.
     *
     * @param Request $request
     * @return ComplaintCollection
     */
    public function index(Request $request)
    {
        $complaints = Complaint::query();

        // Filter the complaints
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'P': // Pending
                case 'S': // Solving
                case 'R': // Resolved
                case 'C': // Cancelled
                    $complaints->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $complaints->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the complaints
        if ($request->has('order')) {
            switch ($request->order) {
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

        // Search the complaints by name of user
        if ($request->has('search')) {
            $complaints->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        ComplaintResource::$format = 'simple';
        return ComplaintResource::collection($complaints->paginate(20));
    }

    /**
     * Display the specified complaint.
     *
     * @param  int  $id
     * @return ComplaintResource
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
     * Display the specified user's complaints.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return ComplaintCollection
     */
    public function user(int $id, Request $request)
    {
        $complaints = Complaint::where('user_id', $id);

        // Filter the complaints
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'P': // Pending
                case 'S': // Solving
                case 'R': // Resolved
                case 'C': // Cancelled
                    $complaints->where('status', $request->filter);
                    break;
                case 'D': // Deleted
                    $complaints->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the complaints
        if ($request->has('order')) {
            switch ($request->order) {
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
     * Display the specified complaint's file.
     *
     * @param  int  $id
     * @param  int  $file
     * @return File
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
     * @param  ComplaintRequest  $request
     * @return ComplaintResource
     */
    public function store(ComplaintRequest $request)
    {
        // Check if user is a customer
        if ($request->user_id) {
            $user = User::findOrFail($request->user_id);
            if ($user->role != 'C') {
                return response()->json([
                    'errors' => [
                        'user_id' => [
                            __('messages.invalid_user'),
                        ],
                    ],
                ], 400);
            }
        }

        $complaint = Complaint::create($request->validated());

        // Check if user has uploaded files (Base64)
        if ($request->has('filesBase64') && $request->filesBase64 != null) {
            $i = 0;
            foreach ($request->filesBase64 as $file) {
                $filename = $request->fileNames[$i];
                $file = base64_decode($file);
                Storage::put('complaint_files/' . $complaint->id . '/' . $filename, $file);
                ComplaintFile::create([
                    'complaint_id' => $complaint->id,
                    'filename' => $filename,
                ]);
                $i++;
            }
        }

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

        // Send notification to admins and managers
        $notification = [
            'title' => __('messages.leiria_hotel'),
            'body' => __('messages.new_complaint', ['id' => $complaint->id]),
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

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.complaint')]),
            'complaint' => new ComplaintResource($complaint),
        ], 201);
    }

    /**
     * Update the specified complaint in storage.
     *
     * @param  ComplaintRequest  $request
     * @param  int  $id
     * @return ComplaintResource
     */
    public function update(ComplaintRequest $request, int $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update($request->validated());

        // Send notification to user
        if ($complaint->user && $complaint->user->fcm_token) {
            $notification = [
                'title' => __('messages.leiria_hotel'),
                'body' => __('messages.response_complaint', ['date' => $complaint->created_at]),
            ];

            FCMService::send($complaint->user->fcm_token, $notification);
        }

        return response()->json([
            'message' => __('messages.updated2', ['attribute' => __('messages.attributes.complaint')]),
            'complaint' => new ComplaintResource($complaint),
        ]);
    }

    /**
     * Remove the specified complaint from storage.
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

        Complaint::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted2', ['attribute' => __('messages.attributes.complaint')]),
        ]);
    }
}
