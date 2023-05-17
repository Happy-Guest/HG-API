<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteRequest;

class ReviewController extends Controller
{
    /**
     * Display a listing of the Reviews.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ReviewResource::$format = 'simple';
        return ReviewResource::collection(Review::paginate(20));
    }

    /**
     * Display the specified Review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Display the specified user's Reviews.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(int $id)
    {
        ReviewResource::$format = 'simple';
        return ReviewResource::collection(Review::where('user_id', $id)->paginate(20));
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());

        return response()->json([
            'message' => __('messages.created2', ['attribute' => __('messages.attributes.review')]),
            'review' => new ReviewResource($review),
        ], 201);
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
