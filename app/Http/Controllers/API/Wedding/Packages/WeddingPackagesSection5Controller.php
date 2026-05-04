<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WeddingPackagesSection5Controller extends Controller
{
    public function getSection()
    {
        try {
            $section = WeddingPackagesSection5::first();
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 5 not found'
                ], 404);
            }

            // Build blocks array
            $blocks = [];
            for ($block = 1; $block <= 4; $block++) {
                $imageValue = $section->{"block{$block}_image"} ?? null;
                if ($imageValue && !filter_var($imageValue, FILTER_VALIDATE_URL)) {
                    $imageValue = asset('storage/' . ltrim($imageValue, '/'));
                }
                
                $blockItems = [];
                for ($item = 1; $item <= 4; $item++) {
                    $itemValue = $section->{"block{$block}_item{$item}"} ?? null;
                    if (!empty($itemValue)) {
                        $blockItems[] = $itemValue;
                    }
                }
                
                $blocks[] = [
                    'title' => $section->{"block{$block}_title"} ?? null,
                    'image_url' => $imageValue,
                    'items' => $blockItems,
                ];
            }
            
            // Filter out empty blocks (no title and no items)
            $blocks = array_filter($blocks, function($block) {
                return !empty($block['title']) || !empty($block['items']);
            });
            $blocks = array_values($blocks);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $section->id,
                    'title' => $section->title,
                    'subtitle' => $section->subtitle,
                    'blocks' => $blocks,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getSection: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $section = WeddingPackagesSection5::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ]);
            
            return $this->update($request, $section->id);
        } catch (\Exception $e) {
            Log::error('Error in store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $section = WeddingPackagesSection5::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 5 not found'
                ], 404);
            }

            // Update title and subtitle
            if ($request->has('title')) {
                $section->title = $request->title;
            }
            if ($request->has('subtitle')) {
                $section->subtitle = $request->subtitle;
            }
            
            // Reset all block data
            for ($block = 1; $block <= 4; $block++) {
                $section->{"block{$block}_title"} = null;
                $section->{"block{$block}_image"} = null;
                for ($item = 1; $item <= 4; $item++) {
                    $section->{"block{$block}_item{$item}"} = null;
                }
            }
            
            // Process blocks from request
            $blocks = $request->blocks ?? [];
            foreach ($blocks as $index => $block) {
                $blockNum = $index + 1;
                if ($blockNum > 4) continue;
                
                $section->{"block{$blockNum}_title"} = $block['title'] ?? null;
                
                // Handle image upload
                if (isset($block['image']) && $block['image'] instanceof \Illuminate\Http\UploadedFile) {
                    // Delete old image
                    $oldImage = $section->{"block{$blockNum}_image"};
                    if ($oldImage && !filter_var($oldImage, FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                    $path = $block['image']->store('wedding-packages-section5', 'public');
                    $section->{"block{$blockNum}_image"} = $path;
                } elseif (isset($block['image_url']) && $block['image_url']) {
                    $section->{"block{$blockNum}_image"} = $block['image_url'];
                }
                
                // Process items
                $items = $block['items'] ?? [];
                foreach ($items as $itemIndex => $item) {
                    $itemNum = $itemIndex + 1;
                    if ($itemNum <= 4 && !empty($item)) {
                        $section->{"block{$blockNum}_item{$itemNum}"} = $item;
                    }
                }
            }
            
            $section->save();
            
            // Build response blocks
            $responseBlocks = [];
            for ($block = 1; $block <= 4; $block++) {
                $imageValue = $section->{"block{$block}_image"} ?? null;
                if ($imageValue && !filter_var($imageValue, FILTER_VALIDATE_URL)) {
                    $imageValue = asset('storage/' . ltrim($imageValue, '/'));
                }
                
                $blockItems = [];
                for ($item = 1; $item <= 4; $item++) {
                    $itemValue = $section->{"block{$block}_item{$item}"} ?? null;
                    if (!empty($itemValue)) {
                        $blockItems[] = $itemValue;
                    }
                }
                
                if (!empty($section->{"block{$block}_title"}) || !empty($blockItems)) {
                    $responseBlocks[] = [
                        'title' => $section->{"block{$block}_title"} ?? null,
                        'image_url' => $imageValue,
                        'items' => $blockItems,
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Wedding packages section 5 updated successfully',
                'data' => [
                    'id' => $section->id,
                    'title' => $section->title,
                    'subtitle' => $section->subtitle,
                    'blocks' => $responseBlocks,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in update: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $section = WeddingPackagesSection5::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 5 not found'
                ], 404);
            }

            // Delete all block images
            for ($block = 1; $block <= 4; $block++) {
                $imageKey = "block{$block}_image";
                if ($section->$imageKey && !filter_var($section->$imageKey, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->$imageKey);
                }
            }

            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wedding packages section 5 deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}