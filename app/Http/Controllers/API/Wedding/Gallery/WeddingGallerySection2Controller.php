<?php

namespace App\Http\Controllers\API\Wedding\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Gallery\WeddingGallerySection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

    // Create section 2 (admin)
    public function store(Request $request)
    {
        $existing = WeddingGallerySection2::first();
        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'Wedding gallery section 2 already exists',
                'data' => $existing
            ]);
        }

        // Create array with 30 empty slots
        $emptyImages = array_fill(0, 30, '');

        $section = WeddingGallerySection2::create([
            'images' => $emptyImages
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery section 2 created successfully',
            'data' => $section
        ], 201);
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

        // Start with existing images
        $existingImages = $section->images ?? [];
        
        // Ensure we have 30 slots, preserving existing values
        $images = [];
        for ($i = 0; $i < 30; $i++) {
            $images[$i] = $existingImages[$i] ?? '';
        }

        Log::info('Starting update', ['existing' => $images]);

        // STEP 1: Handle URL updates (existing images from the frontend)
        for ($i = 0; $i < 30; $i++) {
            $urlKey = "image_url_{$i}";
            
            if ($request->has($urlKey)) {
                $url = $request->input($urlKey);
                
                // Skip blob URLs
                if (str_starts_with($url, 'blob:')) {
                    continue;
                }
                
                Log::info("Processing URL for index {$i}: " . substr($url, 0, 80));
                
                if (empty($url)) {
                    // User cleared this slot
                    if (!empty($images[$i]) && !filter_var($images[$i], FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($images[$i]);
                    }
                    $images[$i] = '';
                } else {
                    // Extract relative path if it's a local storage URL
                    $storedPath = $url;
                    if (str_contains($url, '/storage/')) {
                        $storedPath = substr($url, strpos($url, '/storage/') + 9);
                    } elseif (str_contains($url, 'storage/')) {
                        $storedPath = substr($url, strpos($url, 'storage/') + 8);
                    }
                    $images[$i] = $storedPath;
                }
            }
        }

        // STEP 2: Handle file uploads (NEW images)
        for ($i = 0; $i < 30; $i++) {
            $fileKey = "image_{$i}";
            
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                
                Log::info("Processing file upload for index {$i}: {$file->getClientOriginalName()}");
                
                // Delete old image if it was a local file
                if (!empty($images[$i]) && !filter_var($images[$i], FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($images[$i]);
                }
                
                // Store new image
                $path = $file->store('wedding-gallery-section2', 'public');
                $images[$i] = $path;
                
                Log::info("Saved file to: {$path}");
            }
        }

        // Save to database
        $section->images = $images;
        $section->save();

        Log::info('Update completed', ['saved' => array_filter($images)]);

        // Prepare response with full URLs
        $returnImages = $images;
        foreach ($returnImages as &$img) {
            if ($img && !filter_var($img, FILTER_VALIDATE_URL)) {
                $img = asset('storage/' . ltrim($img, '/'));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery section 2 updated successfully',
            'data' => [
                'id' => $section->id,
                'images' => $returnImages
            ]
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