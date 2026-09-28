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
        if ($request->filled('category')) {
            $cat = $request->category;
            $query->where(function ($q) use ($cat) {
                if (is_numeric($cat)) {
                    $q->where('category_id', $cat);
                } else {
                    $cleaned = str_replace('-', ' ', $cat);
                    $q->whereHas('category', function ($cq) use ($cleaned) {
                        $cq->where('name', 'like', '%' . $cleaned . '%');
                    });
                }
            });
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

        $paginated = $query->latest()->paginate(20);
        $this->ensureProductImages($paginated->items());

        return response()->json([
            'status' => true,
            'data'   => $paginated,
        ]);
    }

    public function show(Product $product)
    {
        $this->ensureProductImages([$product]);

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
        } elseif ($request->filled('image_path')) {
            $validated['image_path'] = $request->input('image_path');
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
            'image_path'     => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_path')) {
            $validated['image_path'] = $request->input('image_path');
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

    private function ensureProductImages($products)
    {
        $imageMap = [
            'tomato'      => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=600&auto=format&fit=crop&q=80',
            'potato'      => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=600&auto=format&fit=crop&q=80',
            'onion'       => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=600&auto=format&fit=crop&q=80',
            'carrot'      => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5c317?w=600&auto=format&fit=crop&q=80',
            'spinach'     => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=600&auto=format&fit=crop&q=80',
            'lettuce'     => 'https://images.unsplash.com/photo-1622206151226-18ca2c9ab4a1?w=600&auto=format&fit=crop&q=80',
            'kale'        => 'https://images.unsplash.com/photo-1524179091875-bf99a9a6fa57?w=600&auto=format&fit=crop&q=80',
            'pepper'      => 'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=600&auto=format&fit=crop&q=80',
            'cucumber'    => 'https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=600&auto=format&fit=crop&q=80',
            'apple'       => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=600&auto=format&fit=crop&q=80',
            'banana'      => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=600&auto=format&fit=crop&q=80',
            'strawberr'   => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=600&auto=format&fit=crop&q=80',
            'berry'       => 'https://images.unsplash.com/photo-1596363505729-4190a9506133?w=600&auto=format&fit=crop&q=80',
            'orange'      => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=600&auto=format&fit=crop&q=80',
            'lemon'       => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=600&auto=format&fit=crop&q=80',
            'peach'       => 'https://images.unsplash.com/photo-1629828874514-c1e5103f2150?w=600&auto=format&fit=crop&q=80',
            'grape'       => 'https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=600&auto=format&fit=crop&q=80',
            'egg'         => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=600&auto=format&fit=crop&q=80',
            'milk'        => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&auto=format&fit=crop&q=80',
            'cheese'      => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=600&auto=format&fit=crop&q=80',
            'butter'      => 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=600&auto=format&fit=crop&q=80',
            'honey'       => 'https://images.unsplash.com/photo-1587049352847-4a222e784d38?w=600&auto=format&fit=crop&q=80',
            'bread'       => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80',
            'flour'       => 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=600&auto=format&fit=crop&q=80',
            'corn'        => 'https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=600&auto=format&fit=crop&q=80',
            'basil'       => 'https://images.unsplash.com/photo-1608686207856-001b95cf60ca?w=600&auto=format&fit=crop&q=80',
            'mint'        => 'https://images.unsplash.com/photo-1628556270448-4d4e4148e1b1?w=600&auto=format&fit=crop&q=80',
            'herb'        => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?w=600&auto=format&fit=crop&q=80',
            'garlic'      => 'https://images.unsplash.com/photo-1540148426945-6cf22a6b2383?w=600&auto=format&fit=crop&q=80',
            'broccoli'    => 'https://images.unsplash.com/photo-1459411621453-7b03977f4bfc?w=600&auto=format&fit=crop&q=80',
            'mushroom'    => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&auto=format&fit=crop&q=80',
        ];

        foreach ($products as $p) {
            if ($p instanceof Product && empty($p->image_path)) {
                $lower = strtolower($p->name);
                $matched = null;
                foreach ($imageMap as $kw => $url) {
                    if (str_contains($lower, $kw)) {
                        $matched = $url;
                        break;
                    }
                }
                if ($matched) {
                    $p->update(['image_path' => $matched]);
                    $p->image_path = $matched;
                }
            }
        }
    }
}