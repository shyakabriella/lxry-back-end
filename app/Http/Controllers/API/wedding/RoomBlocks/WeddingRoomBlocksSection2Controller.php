<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeddingRoomBlocksSection2Controller extends Controller
{
    public function getSection()
    {
        $items = WeddingRoomBlocksSection2::orderBy('sort_order', 'asc')->get();
        
        foreach ($items as $item) {
            // Convert single image URL (backward compatibility)
            if ($item->image_url && !filter_var($item->image_url, FILTER_VALIDATE_URL)) {
                $item->image_url = asset('storage/' . $item->image_url);
            }
            
            // Convert multiple images
            if ($item->images) {
                $images = json_decode($item->images, true);
                foreach ($images as &$image) {
                    if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                        $image = asset('storage/' . $image);
                    }
                }
                $item->images = $images;
            } else {
                $item->images = ['', '', ''];
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    public function store(Request $request)
    {
        $item = new WeddingRoomBlocksSection2();
        $item->title = $request->title;
        $item->subtitle = $request->subtitle ?? '';
        $item->description = $request->description ?? '';
        $item->sort_order = $request->sort_order ?? 0;
        
        // Handle multiple images
        $images = ['', '', ''];
        
        for ($i = 0; $i < 3; $i++) {
            $fileKey = "image_{$i}";
            $urlKey = "image_url_{$i}";
            
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('wedding-room-blocks-section2', 'public');
                $images[$i] = $path;
            } elseif ($request->has($urlKey) && $request->$urlKey) {
                $images[$i] = $request->$urlKey;
            }
        }
        
        $item->images = json_encode($images);
        $item->save();
        
        // Return with full URLs
        $returnImages = $images;
        foreach ($returnImages as &$img) {
            if ($img && !filter_var($img, FILTER_VALIDATE_URL)) {
                $img = asset('storage/' . $img);
            }
        }
        $item->images = $returnImages;
        
        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = WeddingRoomBlocksSection2::find($id);
        
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }
        
        if ($request->has('title')) {
            $item->title = $request->title;
        }
        if ($request->has('subtitle')) {
            $item->subtitle = $request->subtitle;
        }
        if ($request->has('description')) {
            $item->description = $request->description;
        }
        if ($request->has('sort_order')) {
            $item->sort_order = $request->sort_order;
        }
        
        // Get existing images
        $existingImages = json_decode($item->images, true) ?? ['', '', ''];
        $images = $existingImages;
        
        // Handle multiple images
        for ($i = 0; $i < 3; $i++) {
            $fileKey = "image_{$i}";
            $urlKey = "image_url_{$i}";
            
            if ($request->hasFile($fileKey)) {
                // Delete old image if exists
                if ($existingImages[$i] && !filter_var($existingImages[$i], FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($existingImages[$i]);
                }
                $path = $request->file($fileKey)->store('wedding-room-blocks-section2', 'public');
                $images[$i] = $path;
            } elseif ($request->has($urlKey)) {
                $images[$i] = $request->$urlKey;
            }
        }
        
        $item->images = json_encode($images);
        $item->save();
        
        // Return with full URLs
        $returnImages = $images;
        foreach ($returnImages as &$img) {
            if ($img && !filter_var($img, FILTER_VALIDATE_URL)) {
                $img = asset('storage/' . $img);
            }
        }
        $item->images = $returnImages;
        
        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $item
        ]);
    }
    
    public function destroy($id)
    {
        $item = WeddingRoomBlocksSection2::find($id);
        
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }
        
        // Delete all images
        $images = json_decode($item->images, true) ?? [];
        foreach ($images as $image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $item->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}