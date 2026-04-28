<?php

namespace App\Http\Controllers\API\Wedding\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Gallery\WeddingGallerySection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingGallerySection2Controller extends Controller
{
    // Get gallery images (public)
    public function getImages()
    {
        $gallery = WeddingGallerySection2::first();
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery images not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $gallery->images
        ]);
    }

    // Create or update gallery images (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $gallery = WeddingGallerySection2::first();
        
        if ($gallery) {
            $gallery->update(['images' => $request->images]);
            $message = 'Wedding gallery images updated successfully';
        } else {
            $gallery = WeddingGallerySection2::create(['images' => $request->images]);
            $message = 'Wedding gallery images created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $gallery->images
        ]);
    }

    // Update gallery images (admin)
    public function update(Request $request, $id)
    {
        $gallery = WeddingGallerySection2::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $gallery->update(['images' => $request->images]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery images updated successfully',
            'data' => $gallery->images
        ]);
    }

    // Delete gallery (admin)
    public function destroy($id)
    {
        $gallery = WeddingGallerySection2::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery not found'
            ], 404);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery deleted successfully'
        ]);
    }
}