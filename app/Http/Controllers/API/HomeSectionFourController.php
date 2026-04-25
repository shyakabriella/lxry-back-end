<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionFour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionFourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = HomeSectionFour::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Home section four slides fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Display active slides only for frontend.
     */
    public function active()
    {
        $items = HomeSectionFour::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active home section four slides fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title_line_one' => ['required', 'string', 'max:255'],
            'title_line_two' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-section-four', 'public');
        }

        $item = HomeSectionFour::create([
            'eyebrow' => $validated['eyebrow'] ?? null,
            'title_line_one' => $validated['title_line_one'],
            'title_line_two' => $validated['title_line_two'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Home section four slide created successfully.',
            'data' => $item,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = HomeSectionFour::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section four slide not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Home section four slide fetched successfully.',
            'data' => $item,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = HomeSectionFour::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section four slide not found.',
            ], 404);
        }

        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title_line_one' => ['sometimes', 'required', 'string', 'max:255'],
            'title_line_two' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('home-section-four', 'public');
        }

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Home section four slide updated successfully.',
            'data' => $item->fresh(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = HomeSectionFour::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section four slide not found.',
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Home section four slide deleted successfully.',
        ], 200);
    }
}