<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()
            ->user()
            ->reviews()
            ->latest()
            ->paginate(20);

        return view('front::reviews.index', compact('reviews'));
    }

    public function show(Product $product)
    {
        $review = $product->reviews()->with('points')->where('user_id', auth()->user()->id)->first();

        return response()->json(['review' => $review]);
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $data = $this->validate($request, [
            'title'       => 'required|string',
            'body'        => 'required|string|max:1000',
            'rating'      => 'required|between:1,5',
        ]);

        if ($request->user()->hasBoughtProduct($product)) {
            $request->validate([
                'suggest'     => 'required|in:yes,no,not_sure',
            ]);

            $data['suggest'] = $request->suggest;
        }

        $data['status'] = 'pending';

        $review = $product->reviews()->updateOrCreate(
            [
                'user_id' => auth()->user()->id
            ],
            $data
        );

        $review->points()->delete();

        $advantages = $request->input('review.advantages');

        if ($advantages) {
            foreach ($advantages as $advantage) {
                $review->points()->create([
                    'text' => $advantage,
                    'type' => 'positive',
                ]);
            }
        }

        $disadvantages = $request->input('review.disadvantages');

        if ($disadvantages) {
            foreach ($disadvantages as $advantage) {
                $review->points()->create([
                    'text' => $advantage,
                    'type' => 'negative',
                ]);
            }
        }

        $product->refreshRating();

        return response('success');
    }

    public function like(Review $review)
    {
        $review->likes()->updateOrCreate(
            [
                'user_id' => auth()->user()->id
            ],
            [
                'type' => 'like'
            ],
        );

        $review->refreshLikesCount();

        return response()->json(['review' => $review]);
    }

    public function dislike(Review $review)
    {
        $review->likes()->updateOrCreate(
            [
                'user_id' => auth()->user()->id
            ],
            [
                'type' => 'dislike'
            ],
        );

        $review->refreshLikesCount();

        return response()->json(['review' => $review]);
    }
}
