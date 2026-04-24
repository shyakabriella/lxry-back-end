<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionFive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionFiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = HomeSectionFive::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Home section five list fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Display only active records.
     */
    public function active()
    {
        $items = HomeSectionFive::where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active home section five data fetched successfully.',
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-section-five', 'public');
        }

        $item = HomeSectionFive::create([
            'eyebrow' => $validated['eyebrow'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'image' => $validated['image'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Home section five created successfully.',
            'data' => $item,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = HomeSectionFive::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section five not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Home section five fetched successfully.',
            'data' => $item,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = HomeSectionFive::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section five not found.',
            ], 404);
        }

        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('home-section-five', 'public');
        }

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Home section five updated successfully.',
            'data' => $item->fresh(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = HomeSectionFive::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section five not found.',
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Home section five deleted successfully.',
        ], 200);
    }
}