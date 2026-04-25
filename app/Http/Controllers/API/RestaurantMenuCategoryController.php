<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RestaurantMenuCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantMenuCategoryController extends Controller
{
    /**
     * Get all categories.
     */
    public function index(Request $request)
    {
        $query = RestaurantMenuCategory::query()
            ->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $categories = $query->get();

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Restaurant menu categories fetched successfully.',
            'data' => $categories,
        ], 200);
    }

    /**
     * Get active categories only.
     */
    public function active(Request $request)
    {
        $query = RestaurantMenuCategory::where('is_active', true)
            ->orderBy('name');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $categories = $query->get();

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Active restaurant menu categories fetched successfully.',
            'data' => $categories,
        ], 200);
    }

    /**
     * Create category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('restaurant_menu_categories', 'name')
                    ->where(fn ($query) => $query->where('type', $request->type)),
            ],
            'type' => ['required', Rule::in(['restaurant', 'bar'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category = RestaurantMenuCategory::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201);
    }

    /**
     * Show single category.
     */
    public function show(string $id)
    {
        $category = RestaurantMenuCategory::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Category fetched successfully.',
            'data' => $category,
        ], 200);
    }

    /**
     * Update category.
     */
    public function update(Request $request, string $id)
    {
        $category = RestaurantMenuCategory::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        $type = $request->type ?? $category->type;

        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('restaurant_menu_categories', 'name')
                    ->ignore($category->id)
                    ->where(fn ($query) => $query->where('type', $type)),
            ],
            'type' => ['sometimes', 'required', Rule::in(['restaurant', 'bar'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category->update($validated);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $category->fresh(),
        ], 200);
    }

    /**
     * Delete category.
     */
    public function destroy(string $id)
    {
        $category = RestaurantMenuCategory::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        if ($category->menuItems()->count() > 0) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'This category has food/drink items. Delete or move the items first.',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Category deleted successfully.',
        ], 200);
    }
}