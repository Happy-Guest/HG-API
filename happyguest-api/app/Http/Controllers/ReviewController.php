<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     *
     * @param Request $request
     * @return ReviewCollection
     */
    public function index(Request $request)
    {
        $reviews = Review::query();

        // Filter the reviews
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'S': // Shared
                    $reviews->where('shared', true);
                    break;
                case 'NS': // Not shared
                    $reviews->where('shared', false);
                    break;
                case 'A': // Autorized
                    $reviews->where('autorize', true);
                    break;
                case 'NA': // Not autorized
                    $reviews->where('autorize', false);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the reviews
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $reviews->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $reviews->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ReviewResource::$format = 'simple';
        return ReviewResource::collection($reviews->paginate(20));
    }

    /**
     * Display the specified review.
     *
     * @param  int  $id
     * @return ReviewResource
     */
    public function show(int $id)
    {
        $review = Review::findOrFail($id);

        // Check if authenticated user is the same as the review's user
        if ($review->user_id != auth()->user()->id && auth()->user()->role != 'A' && auth()->user()->role != 'M') {
            return response()->json([
                'message' => __('messages.unauthorized'),
            ], 401);
        }

        ReviewResource::$format = 'detailed';
        return new ReviewResource($review);
    }

    /**
     * Display the specified user's reviews.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return ReviewCollection
     */
    public function user(int $id, Request $request)
    {
        $reviews = Review::where('user_id', $id);

        // Filter the reviews
        if ($request->has('filter') && $request->filter != 'ALL') {
            switch ($request->filter) {
                case 'S': // Shared
                    $reviews->where('shared', true);
                    break;
                case 'NS': // Not shared
                    $reviews->where('shared', false);
                    break;
                case 'A': // Autorized
                    $reviews->where('autorize', true);
                    break;
                case 'NA': // Not autorized
                    $reviews->where('autorize', false);
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_filter'),
                    ], 400);
            }
        }

        // Order the reviews
        if ($request->has('order')) {
            switch ($request->order) {
                case 'ASC': // Ascending
                    $reviews->orderBy('id', 'asc');
                    break;
                case 'DESC': // Descending
                    $reviews->orderBy('id', 'desc');
                    break;
                default:
                    return response()->json([
                        'message' => __('messages.invalid_order'),
                    ], 400);
            }
        }

        ReviewResource::$format = 'simple';
        return ReviewResource::collection($reviews->paginate(20));
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  ReviewRequest  $request
     * @return ReviewResource
     */
    public function store(ReviewRequest $request)
    {
        // Check if user has a recent review
        if (Review::where('user_id', auth()->user()->id)->where('created_at', '>', now()->subDays(7))->exists()) {
            return response()->json([
                'message' => __('messages.recent_review'),
            ], 400);
        }

        $review = Review::create($request->validated());

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.review')]),
            'review' => new ReviewResource($review),
        ], 201);
    }

    /**
     * Remove the specified review from storage.
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

        Review::findOrFail($id)->delete();

        return response()->json([
            'message' => __('messages.deleted', ['attribute' => __('messages.attributes.review')]),
        ]);
    }
}
