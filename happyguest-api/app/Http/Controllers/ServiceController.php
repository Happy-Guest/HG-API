<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\DeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     *
     * @param Request $request
     * @return ServiceCollection
     */
    public function index(Request $request)
    {
        $services = Service::query();

        // Filter the services
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'C': // Cleaning
                case 'B': // Object
                case 'F': // Food
                case 'R': // Restaurant
                case 'O': // Other
                    $services->where('type', $request->filter);
                    break;
                case 'D': // Deleted
                    $services->where('deleted_at', '!=', null)->withTrashed();
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the services
        if ($request->has('service')) {
            switch ($request->service) {
                case 'ASC': // Ascending
                    $services->serviceBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $services->serviceBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ServiceResource::$format = 'simple';
        return ServiceResource::collection($services->paginate(20));
    }

    /**
     * Display the specified service.
     *
     * @param int $id
     * @return ServiceResource
     */
    public function show(int $id)
    {
        $service = Service::findOrFail($id);

        ServiceResource::$format = 'detailed';
        return new ServiceResource($service);
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  ServiceRequest  $request
     * @return ServiceResource
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        // Check if user has uploaded a menu
        if ($request->hasFile('menu')) {
            $file = $request->file('menu');
            $file_name = $service->id . '.pdf';
            $file->move(storage_path('app/public/services'), $file_name);
            $service->menu_url = $file_name;
            $service->update();
        }

        return response()->json([
            'message' => __('messages.created', ['attribute' => __('messages.attributes.service')]),
            'service' => new ServiceResource($service),
        ], 201);
    }

    /**
     * Update the specified service in storage.
     *
     * @param  ServiceRequest  $request
     * @param  int  $id
     * @return ServiceResource
     */
    public function update(ServiceRequest $request, int $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->validated());

        // Check if user has uploaded a menu
        if ($request->hasFile('menu')) {
            $file = $request->file('menu');
            $file_name = $service->id . '.pdf';
            $file->move(storage_path('app/public/services'), $file_name);
            $service->menu_url = $file_name;
            $service->update();
        }

        return response()->json([
            'message' => __('messages.updated', ['attribute' => __('messages.attributes.service')]),
            'service' => new ServiceResource($service),
        ]);
    }

    /**
     * Remove the specified service from storage.
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

        // Check if service is important
        if (Service::findOrFail($id) <= 6) {
            return response()->json([
                'message' => __('messages.important_service'),
            ], 400);
        }

        Service::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.service')]),
        ]);
    }
}
