<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function farmerReviews($farmer)
    {
        $reviews = Review::with('customer')
            ->where('farmer_profile_id', $farmer)
            ->where('is_visible', true)
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data'   => $reviews,
        ]);
    }

    public function productReviews($product)
    {
        $reviews = Review::with('customer')
            ->where('product_id', $product)
            ->where('is_visible', true)
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data'   => $reviews,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_profile_id' => 'required|exists:farmer_profiles,id',
            'product_id'        => 'nullable|exists:products,id',
            'order_id'          => 'nullable|exists:orders,id',
            'rating'            => 'required|integer|min:1|max:5',
            'comment'           => 'nullable|string|max:1000',
        ]);

        if ($validated['order_id'] ?? null) {
            $order = Order::find($validated['order_id']);
            if (!$order || $order->customer_id !== $request->user()->id) {
                return response()->json(['status' => false, 'message' => 'Order not found.'], 403);
            }
            if ($order->status !== 'completed') {
                return response()->json(['status' => false, 'message' => 'You can only review completed orders.'], 422);
            }
        }

        $already = Review::where('customer_id', $request->user()->id)
            ->where('farmer_profile_id', $validated['farmer_profile_id'])
            ->when($validated['product_id'] ?? null, fn($q) => $q->where('product_id', $validated['product_id']))
            ->when($validated['order_id'] ?? null, fn($q) => $q->where('order_id', $validated['order_id']))
            ->exists();

        if ($already) {
            return response()->json(['status' => false, 'message' => 'You have already reviewed this.'], 422);
        }

        $validated['customer_id'] = $request->user()->id;

        $review = Review::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Review submitted',
            'data'    => $review->load('customer'),
        ], 201);
    }

    public function update(Request $request, Review $review)
    {
        if ($review->customer_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Review updated',
            'data'    => $review,
        ]);
    }

    public function destroy(Request $request, Review $review)
    {
        if ($review->customer_id !== $request->user()->id) {
            abort(403);
        }

        $review->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Review deleted',
        ]);
    }

    public function farmerIndex(Request $request)
    {
        $farmer  = $request->user()->farmerProfile;
        $reviews = Review::with('customer', 'product')
            ->where('farmer_profile_id', $farmer->id)
            ->where('is_visible', true)
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data'   => $reviews,
        ]);
    }

    public function reply(Request $request, Review $review)
    {
        $farmer = $request->user()->farmerProfile;

        if ($review->farmer_profile_id !== $farmer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'farmer_reply' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Reply posted',
            'data'    => $review,
        ]);
    }

    public function adminIndex()
    {
        $reviews = Review::with('customer', 'product', 'farmer.user')
            ->latest()
            ->paginate(30);

        return response()->json([
            'status' => true,
            'data'   => $reviews,
        ]);
    }

    public function adminDestroy(Review $review)
    {
        $review->update(['is_visible' => false]);

        return response()->json([
            'status'  => true,
            'message' => 'Review hidden',
        ]);
    }
}
