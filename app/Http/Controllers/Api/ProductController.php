<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['farmer.user', 'market', 'category'])
                        ->where('status', 'available');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('farmer_profile_id')) {
            $query->where('farmer_profile_id', $request->farmer_profile_id);
        }
        if ($request->filled('market_id')) {
            $marketId = $request->market_id;
            $query->where(function ($q) use ($marketId) {
                $q->where('market_id', $marketId)
                  ->orWhereHas('farmer', function ($fq) use ($marketId) {
                      $fq->where('market_id', $marketId);
                  });
            });
        }
        if ($request->filled('market_day')) {
            $day = $request->market_day;
            $query->whereHas('farmer', function ($q) use ($day) {
                $q->where('operating_days', 'like', '%' . $day . '%')
                  ->orWhereHas('market', function ($mq) use ($day) {
                      $mq->where('open_days', 'like', '%' . $day . '%');
                  });
            });
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->boolean('in_stock_only')) {
            $query->where('stock_quantity', '>', 0);
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(20),
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'data'   => $product->load(['farmer.user', 'market', 'category', 'reviews.customer']),
        ]);
    }

    public function myProducts(Request $request)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer) {
            return response()->json([
                'status'  => true,
                'message' => 'No farmer profile found. Please create your profile first.',
                'data'    => [],
            ]);
        }

        return response()->json([
            'status' => true,
            'data'   => $farmer->products()->with(['category', 'market'])->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer) {
            return response()->json([
                'status'  => false,
                'message' => 'Please create your farmer profile before adding products.',
            ], 422);
        }

        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'market_id'      => 'nullable|exists:markets,id',
            'name'           => 'required|string|max:100',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'unit'           => 'required|string|max:20',
            'stock_quantity' => 'required|integer|min:0',
            'status'         => 'sometimes|in:available,sold_out,hidden',
            'image'          => 'nullable|image|max:2048',
        ]);

        if (empty($validated['market_id']) && $farmer->market_id) {
            $validated['market_id'] = $farmer->market_id;
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $validated['farmer_profile_id'] = $farmer->id;

        $product = Product::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product created',
            'data'    => $product->load(['category', 'market']),
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $validated = $request->validate([
            'category_id'    => 'sometimes|exists:categories,id',
            'market_id'      => 'nullable|exists:markets,id',
            'name'           => 'sometimes|string|max:100',
            'description'    => 'nullable|string',
            'price'          => 'sometimes|numeric|min:0',
            'unit'           => 'sometimes|string|max:20',
            'stock_quantity' => 'sometimes|integer|min:0',
            'status'         => 'sometimes|in:available,sold_out,hidden',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product updated',
            'data'    => $product->load(['category', 'market']),
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted',
        ]);
    }

    public function updateStatus(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $validated = $request->validate([
            'status' => 'required|in:available,sold_out,hidden',
        ]);

        $product->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Status updated',
            'data'    => $product,
        ]);
    }

    private function authorizeProduct(Request $request, Product $product)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer || $product->farmer_profile_id !== $farmer->id) {
            abort(403, 'You do not own this product.');
        }
    }

    public function adminIndex(Request $request)
    {
        $query = Product::with(['farmer.user', 'market', 'category']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(30),
        ]);
    }

    public function adminDestroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product removed',
        ]);
    }

    public function showOwn(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        return response()->json([
            'status' => true,
            'data'   => $product->load(['category', 'market']),
        ]);
    }
}