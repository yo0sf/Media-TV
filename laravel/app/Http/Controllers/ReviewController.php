<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Series $series)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'series_id' => $series->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'is_approved' => true,
            ]
        );

        return back()->with('success', __('app.review_posted'));
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isManager()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
