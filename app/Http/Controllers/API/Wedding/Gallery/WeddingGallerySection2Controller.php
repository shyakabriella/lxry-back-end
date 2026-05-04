<?php

namespace App\Http\Controllers\API\Wedding\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Gallery\WeddingGallerySection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeddingGallerySection2Controller extends Controller
{
    // Get section 2 (public)
    public function getSection()
    {
        $section = WeddingGallerySection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery section 2 not found'
            ], 404);
        }

        // Convert storage paths to full URLs
        $images = $section->images ?? [];
        foreach ($images as &$image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                $image = asset('storage/' . ltrim($image, '/'));
            }
        }
        $section->images = $images;

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create section 2 (admin) - No validation required
    public function store(Request $request)
    {
        // Simply create a new record with empty images array
        $section = WeddingGallerySection2::create([
            'images' => []
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery section 2 created successfully',
            'data' => $section
        ]);
    }

    // Update section 2 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingGallerySection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery section 2 not found'
            ], 404);
        }

        // Get existing images
        $existingImages = $section->images ?? [];
        $images = $existingImages;
        
        // Handle file uploads for up to 30 images (image_0, image_1, etc.)
        for ($i = 0; $i < 30; $i++) {
            $fileKey = "image_{$i}";
            
            if ($request->hasFile($fileKey)) {
                // Delete old image if exists and it's a stored file (not URL)
                if (!empty($existingImages[$i]) && !filter_var($existingImages[$i], FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($existingImages[$i]);
                }
                // Store new image
                $path = $request->file($fileKey)->store('wedding-gallery-section2', 'public');
                $images[$i] = $path;
            }
        }
        
        // Handle URL updates (image_url_0, image_url_1, etc.)
        for ($i = 0; $i < 30; $i++) {
            $urlKey = "image_url_{$i}";
            
            if ($request->has($urlKey)) {
                $url = $request->$urlKey;
                // Only update if it's a valid URL (not empty, not blob)
                if (!empty($url) && !str_starts_with($url, 'blob:')) {
                    // Delete old file if it was a stored file
                    if (!empty($existingImages[$i]) && !filter_var($existingImages[$i], FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($existingImages[$i]);
                    }
                    $images[$i] = $url;
                } elseif (empty($url)) {
                    // If URL is empty, remove the image
                    if (!empty($existingImages[$i]) && !filter_var($existingImages[$i], FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($existingImages[$i]);
                    }
                    $images[$i] = "";
                }
            }
        }
        
        $section->images = $images;
        $section->save();
        
        // Return with full URLs for response
        $returnImages = $images;
        foreach ($returnImages as &$img) {
            if ($img && !filter_var($img, FILTER_VALIDATE_URL)) {
                $img = asset('storage/' . ltrim($img, '/'));
            }
        }
        $section->images = $returnImages;
        
        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery section 2 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 2 (admin)
    public function destroy($id)
    {
        $section = WeddingGallerySection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery section 2 not found'
            ], 404);
        }

        // Delete all images from storage
        $images = $section->images ?? [];
        foreach ($images as $image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($image);
            }
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery section 2 deleted successfully'
        ]);
    }
}