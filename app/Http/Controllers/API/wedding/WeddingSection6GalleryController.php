<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection6Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingSection6GalleryController extends Controller
{
    // Get wedding gallery images (public)
    public function getGallery()
    {
        $gallery = WeddingSection6Gallery::first();
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $gallery->images
        ]);
    }

    // Create or update wedding gallery (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|size:5',
            'images.*' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $gallery = WeddingSection6Gallery::first();
        
        if ($gallery) {
            $gallery->update(['images' => $request->images]);
            $message = 'Wedding gallery updated successfully';
        } else {
            $gallery = WeddingSection6Gallery::create(['images' => $request->images]);
            $message = 'Wedding gallery created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $gallery->images
        ]);
    }

    // Update wedding gallery images (admin)
    public function update(Request $request, $id)
    {
        $gallery = WeddingSection6Gallery::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'images' => 'required|array|size:5',
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
            'message' => 'Wedding gallery updated successfully',
            'data' => $gallery->images
        ]);
    }

    // Delete wedding gallery (admin)
    public function destroy($id)
    {
        $gallery = WeddingSection6Gallery::find($id);
        
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