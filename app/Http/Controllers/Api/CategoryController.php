<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
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
            'name' => 'sometimes|string|max:100|unique:categories,name,' . $category->id,
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
        $category->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Category deleted',
        ]);
    }
}
