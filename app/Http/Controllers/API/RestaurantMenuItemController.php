<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RestaurantMenuCategory;
use App\Models\RestaurantMenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RestaurantMenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = RestaurantMenuItem::query();

        if ($request->filled('tab')) {
            $query->where('tab', $request->tab);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $items = $query
            ->with('categoryRelation')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu items fetched successfully.',
            'data' => $items,
        ], 200);
    }

    public function active(Request $request)
    {
        $query = RestaurantMenuItem::where('is_active', true);

        if ($request->filled('tab')) {
            $query->where('tab', $request->tab);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query
            ->with('categoryRelation')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active restaurant menu items fetched successfully.',
            'data' => $items,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tab' => ['required', Rule::in(['restaurant', 'bar'])],
            'category_id' => ['required', 'integer', Rule::exists('restaurant_menu_categories', 'id')],
            'category' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $category = RestaurantMenuCategory::find($validated['category_id']);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Selected category not found.',
            ], 404);
        }

        if ($category->type !== $validated['tab']) {
            return response()->json([
                'status' => false,
                'message' => 'Selected category does not belong to this menu type.',
                'errors' => [
                    'category_id' => ['The selected category does not belong to ' . $validated['tab'] . '.'],
                ],
            ], 422);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurant-menu-items', 'public');
        }

        $item = RestaurantMenuItem::create([
            'tab' => $validated['tab'],
            'category_id' => $category->id,
            'category' => $category->name,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu item created successfully.',
            'data' => $item->fresh('categoryRelation'),
        ], 201);
    }

    public function show(string $id)
    {
        $item = RestaurantMenuItem::with('categoryRelation')->find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant menu item not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu item fetched successfully.',
            'data' => $item,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $item = RestaurantMenuItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant menu item not found.',
            ], 404);
        }

        $validated = $request->validate([
            'tab' => ['sometimes', 'required', Rule::in(['restaurant', 'bar'])],
            'category_id' => ['sometimes', 'required', 'integer', Rule::exists('restaurant_menu_categories', 'id')],
            'category' => ['nullable', 'string', 'max:255'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data = $validated;

        if (array_key_exists('category_id', $validated)) {
            $category = RestaurantMenuCategory::find($validated['category_id']);
            $tab = $validated['tab'] ?? $item->tab;

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected category not found.',
                ], 404);
            }

            if ($category->type !== $tab) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected category does not belong to this menu type.',
                    'errors' => [
                        'category_id' => ['The selected category does not belong to ' . $tab . '.'],
                    ],
                ], 422);
            }

            $data['category_id'] = $category->id;
            $data['category'] = $category->name;
        }

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $data['image'] = $request->file('image')->store('restaurant-menu-items', 'public');
        }

        $item->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu item updated successfully.',
            'data' => $item->fresh('categoryRelation'),
        ], 200);
    }

    public function destroy(string $id)
    {
        $item = RestaurantMenuItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant menu item not found.',
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu item deleted successfully.',
        ], 200);
    }
}