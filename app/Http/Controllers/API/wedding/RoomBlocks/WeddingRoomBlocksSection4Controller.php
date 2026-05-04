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
        $section = WeddingRoomBlocksSection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ], 404);
        }

        $cards = $section->cards_data ?? [];
        
        // Convert image paths to full URLs
        foreach ($cards as &$card) {
            if (isset($card['images'])) {
                foreach ($card['images'] as &$image) {
                    if ($image && !filter_var($image, FILTER_VALIDATE_URL) && !str_starts_with($image, 'http')) {
                        $image = asset('storage/' . ltrim($image, '/'));
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $section->id,
                'cards' => $cards,
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $cards = $request->cards ?? [];
            $processedCards = [];
            
            foreach ($cards as $index => $card) {
                $processedCard = [
                    'title' => $card['title'] ?? '',
                    'subtitle' => $card['subtitle'] ?? '',
                    'description' => $card['description'] ?? '',
                    'images' => []
                ];
                
                // Handle 3 images
                for ($i = 0; $i < 3; $i++) {
                    $imagePath = null;
                    
                    // Check if there's an uploaded file
                    if (isset($card["image_{$i}"]) && $card["image_{$i}"]) {
                        $file = $card["image_{$i}"];
                        if (is_object($file) && method_exists($file, 'store')) {
                            $filename = time() . '_' . rand(1000, 9999) . '_' . $i . '.' . $file->getClientOriginalExtension();
                            $imagePath = $file->storeAs('wedding-room-blocks-section2', $filename, 'public');
                        } else {
                            $imagePath = $file;
                        }
                    }
                    // Check if there's an existing image URL
                    elseif (isset($card['images'][$i]) && $card['images'][$i]) {
                        $imagePath = $card['images'][$i];
                        // If it's a full URL, extract the path
                        if (str_contains($imagePath, '/storage/')) {
                            $imagePath = substr($imagePath, strpos($imagePath, '/storage/') + 9);
                        }
                    }
                    
                    $processedCard['images'][] = $imagePath;
                }
                
                $processedCards[] = $processedCard;
            }
            
            $section = WeddingRoomBlocksSection2::first();
            
            if ($section) {
                $section->update(['cards_data' => $processedCards]);
                $message = 'Section updated successfully';
            } else {
                $section = WeddingRoomBlocksSection2::create(['cards_data' => $processedCards]);
                $message = 'Section created successfully';
            }
            
            // Return processed cards with full URLs
            $returnCards = $processedCards;
            foreach ($returnCards as &$card) {
                foreach ($card['images'] as &$image) {
                    if ($image && !filter_var($image, FILTER_VALIDATE_URL) && !str_starts_with($image, 'http')) {
                        $image = asset('storage/' . ltrim($image, '/'));
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $section->id,
                    'cards' => $returnCards,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        $section = WeddingRoomBlocksSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section not found'
            ], 404);
        }
        
        // Delete stored images
        $cards = $section->cards_data ?? [];
        foreach ($cards as $card) {
            if (isset($card['images'])) {
                foreach ($card['images'] as $image) {
                    if ($image && !filter_var($image, FILTER_VALIDATE_URL) && !str_starts_with($image, 'http')) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        }
        
        $section->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully'
        ]);
    }
}