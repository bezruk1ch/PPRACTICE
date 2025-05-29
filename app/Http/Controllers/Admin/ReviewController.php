<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_surname' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $validated['is_for_main_page'] = (bool) $request->input('is_for_main_page', false);

        $review->update($validated);
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв обновлен.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв удален.');
    }
}
