<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionThree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class HomeSectionThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = HomeSectionThree::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Home section three list fetched successfully.',
            'data' => $items,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_one'   => ['required', 'string', 'max:255'],
            'title_two'   => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-section-three', 'public');
        }

        $item = HomeSectionThree::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Home section three created successfully.',
            'data' => $item,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = HomeSectionThree::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section three not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Home section three fetched successfully.',
            'data' => $item,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = HomeSectionThree::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section three not found.',
            ], 404);
        }

        $validated = $request->validate([
            'title_one'   => ['sometimes', 'required', 'string', 'max:255'],
            'title_two'   => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('home-section-three', 'public');
        }

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Home section three updated successfully.',
            'data' => $item->fresh(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = HomeSectionThree::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Home section three not found.',
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Home section three deleted successfully.',
        ], 200);
    }
}