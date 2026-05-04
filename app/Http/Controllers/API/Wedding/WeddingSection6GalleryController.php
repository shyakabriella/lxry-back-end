<?php

namespace App\Http\Controllers\API\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection6Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingSection6GalleryController extends Controller
{
    // Get gallery (public)
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
            'data' => [
                'id' => $gallery->id,
                'images' => $gallery->images,
                'created_at' => $gallery->created_at,
                'updated_at' => $gallery->updated_at
            ]
        ]);
    }

    // Create or update gallery (admin) - Handles both URLs and file uploads
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'nullable|array',
            'existing_images' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $allImages = [];
        
        // Handle existing images (URLs from input fields)
        if ($request->has('existing_images')) {
            $existingImages = json_decode($request->existing_images, true);
            if (is_array($existingImages)) {
                $allImages = array_merge($allImages, $existingImages);
            }
        }
        
        // Handle newly uploaded image files
        if ($request->hasFile('images')) {
            $uploadedFiles = $request->file('images');
            // Handle both single file and multiple files
            $files = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];
            
            foreach ($files as $file) {
                if ($file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('wedding-gallery', $filename, 'public');
                    $allImages[] = $path;
                }
            }
        }

        $gallery = WeddingSection6Gallery::first();
        
        if ($gallery) {
            $gallery->update(['images' => $allImages]);
            $message = 'Wedding gallery updated successfully';
        } else {
            $gallery = WeddingSection6Gallery::create(['images' => $allImages]);
            $message = 'Wedding gallery created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'id' => $gallery->id,
                'images' => $gallery->images,
                'created_at' => $gallery->created_at,
                'updated_at' => $gallery->updated_at
            ]
        ]);
    }

    // Update gallery (admin)
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
            'images' => 'nullable|array',
            'existing_images' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $allImages = [];
        
        // Handle existing images (URLs from input fields)
        if ($request->has('existing_images')) {
            $existingImages = json_decode($request->existing_images, true);
            if (is_array($existingImages)) {
                $allImages = array_merge($allImages, $existingImages);
            }
        }
        
        // Handle newly uploaded image files
        if ($request->hasFile('images')) {
            $uploadedFiles = $request->file('images');
            $files = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];
            
            foreach ($files as $file) {
                if ($file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('wedding-gallery', $filename, 'public');
                    $allImages[] = $path;
                }
            }
        }

        // Delete old images that are being replaced (optional cleanup)
        $oldImages = $gallery->images ?? [];
        foreach ($oldImages as $oldImage) {
            if ($oldImage && !filter_var($oldImage, FILTER_VALIDATE_URL)) {
                $path = preg_replace('/^storage\//', '', $oldImage);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $gallery->update(['images' => $allImages]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery updated successfully',
            'data' => [
                'id' => $gallery->id,
                'images' => $gallery->images,
                'created_at' => $gallery->created_at,
                'updated_at' => $gallery->updated_at
            ]
        ]);
    }

    // Delete gallery (admin)
    public function destroy($id)
    {
        $gallery = WeddingSection6Gallery::find($id);
        
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery not found'
            ], 404);
        }

        // Delete associated images from storage if they are local files
        $images = $gallery->images;
        if (is_array($images)) {
            foreach ($images as $image) {
                // Only delete local files (not external URLs)
                if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                    // Remove 'storage/' prefix if present
                    $path = preg_replace('/^storage\//', '', $image);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery deleted successfully'
        ]);
    }
}