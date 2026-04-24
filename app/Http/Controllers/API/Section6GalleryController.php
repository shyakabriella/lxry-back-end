<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section6Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Section6GalleryController extends Controller
{
    /**
     * Get all active images for frontend sliding gallery.
     */
    public function getActiveImages()
    {
        $images = Section6Gallery::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $images,
        ], 200);
    }

    /**
     * Add new uploaded image to gallery.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'display_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $imagePath = $request->file('image')->store('section-6-gallery', 'public');

        $maxOrder = Section6Gallery::max('display_order') ?? 0;

        $image = Section6Gallery::create([
            'image_url' => $imagePath,
            'display_order' => $request->filled('display_order')
                ? $request->display_order
                : $maxOrder + 1,
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image added successfully.',
            'data' => $image,
        ], 201);
    }

    /**
     * Update gallery image.
     */
    public function update(Request $request, $id)
    {
        $image = Section6Gallery::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'display_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [];

        if ($request->hasFile('image')) {
            if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }

            $data['image_url'] = $request->file('image')->store('section-6-gallery', 'public');
        }

        if ($request->has('display_order')) {
            $data['display_order'] = $request->display_order;
        }

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        $image->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully.',
            'data' => $image->fresh(),
        ], 200);
    }

    /**
     * Delete gallery image.
     */
    public function destroy($id)
    {
        $image = Section6Gallery::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.',
            ], 404);
        }

        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ], 200);
    }
}