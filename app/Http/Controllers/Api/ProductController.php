<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Public: list products with filters
    public function index(Request $request)
    {
        $query = Product::with(['farmer', 'category'])
                        ->where('status', 'available');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('farmer_profile_id')) {
            $query->where('farmer_profile_id', $request->farmer_profile_id);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(20),
        ]);
    }

    // Public: single product
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'data'   => $product->load(['farmer', 'category']),
        ]);
    }

    // Farmer: my products
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
            'data'   => $farmer->products()->with('category')->latest()->paginate(20),
        ]);
    }

    // Farmer: create product
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
            'name'           => 'required|string|max:100',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'unit'           => 'required|string|max:20',
            'stock_quantity' => 'required|integer|min:0',
            'status'         => 'sometimes|in:available,sold_out,hidden',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $validated['farmer_profile_id'] = $farmer->id;

        $product = Product::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product created',
            'data'    => $product,
        ], 201);
    }

    // Farmer: update product
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $validated = $request->validate([
            'category_id'    => 'sometimes|exists:categories,id',
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
            'data'    => $product,
        ]);
    }

    // Farmer: delete product
    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted',
        ]);
    }

    // Farmer: update status
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
        $query = Product::with(['farmer.user', 'category']);

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
            'data'   => $product->load('category'),
        ]);
    }
}