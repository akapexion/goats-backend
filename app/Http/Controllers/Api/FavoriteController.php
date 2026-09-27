<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = Favorite::with('favoritable')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $favorites,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'favoritable_type' => 'required|in:product,farmer',
            'favoritable_id'   => 'required|integer',
        ]);

        $type = $validated['favoritable_type'] === 'product'
            ? Product::class
            : FarmerProfile::class;

        $existing = Favorite::where([
            'user_id'          => $request->user()->id,
            'favoritable_type' => $type,
            'favoritable_id'   => $validated['favoritable_id'],
        ])->first();

        if ($existing) {
            return response()->json([
                'status'  => false,
                'message' => 'Already in favorites',
            ], 422);
        }

        $favorite = Favorite::create([
            'user_id'          => $request->user()->id,
            'favoritable_type' => $type,
            'favoritable_id'   => $validated['favoritable_id'],
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Added to favorites',
            'data'    => $favorite,
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $favorite = Favorite::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $favorite->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Removed from favorites',
        ]);
    }
}
