<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section6Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section6GalleryController extends Controller
{
    /**
     * Get all active images for frontend (for sliding gallery)
     */
    public function getActiveImages()
    {
        $images = Section6Gallery::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    /**
     * Add new image to gallery
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Get highest display order
        $maxOrder = Section6Gallery::max('display_order') ?? 0;
        
        $image = Section6Gallery::create([
            'image_url' => $request->image_url,
            'display_order' => $maxOrder + 1,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image added successfully',
            'data' => $image
        ], 201);
    }

    /**
     * Update image
     */
    public function update(Request $request, $id)
    {
        $image = Section6Gallery::find($id);
        
        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'image_url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $image->update([
            'image_url' => $request->image_url
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully',
            'data' => $image
        ]);
    }

    /**
     * Delete image
     */
    public function destroy($id)
    {
        $image = Section6Gallery::find($id);
        
        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}