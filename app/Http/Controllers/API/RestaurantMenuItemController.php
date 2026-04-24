<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RestaurantMenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantMenuItemController extends Controller
{
    /**
     * Display all menu items.
     */
    public function index(Request $request)
    {
        $query = RestaurantMenuItem::query();

        if ($request->filled('tab')) {
            $query->where('tab', $request->tab);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $items = $query
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu items fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Display active menu items for frontend.
     */
    public function active(Request $request)
    {
        $query = RestaurantMenuItem::where('is_active', true);

        if ($request->filled('tab')) {
            $query->where('tab', $request->tab);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active restaurant menu items fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Store a new menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tab' => ['required', 'in:restaurant,bar'],
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurant-menu-items', 'public');
        }

        $item = RestaurantMenuItem::create([
            'tab' => $validated['tab'],
            'category' => $validated['category'],
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
            'data' => $item,
        ], 201);
    }

    /**
     * Show one menu item.
     */
    public function show(string $id)
    {
        $item = RestaurantMenuItem::find($id);

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

    /**
     * Update a menu item.
     */
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
            'tab' => ['sometimes', 'required', 'in:restaurant,bar'],
            'category' => ['sometimes', 'required', 'string', 'max:255'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('restaurant-menu-items', 'public');
        }

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Restaurant menu item updated successfully.',
            'data' => $item->fresh(),
        ], 200);
    }

    /**
     * Delete a menu item.
     */
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