<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Category::orderBy('name')->get(),
        ]);
    }

    public function show($id)
    {
        $category = is_numeric($id)
            ? Category::find($id)
            : Category::where('name', 'like', '%' . str_replace('-', ' ', $id) . '%')->first();

        if (!$category) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $category,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Category created',
            'data'    => $category,
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Category updated',
            'data'    => $category,
        ]);
    }

    public function destroy(Category $category)
    {
        try {
            Product::where('category_id', $category->id)->update(['category_id' => null]);
            $category->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            try {
                Product::where('category_id', $category->id)->forceDelete();
                $category->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Category deleted successfully',
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Failed to delete category: ' . $ex->getMessage(),
                ], 422);
            }
        }
    }
}
