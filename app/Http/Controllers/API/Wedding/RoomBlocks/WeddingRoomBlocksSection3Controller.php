<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingRoomBlocksSection3Controller extends Controller
{
    // Public GET endpoint - no authentication required
    public function getSection()
    {
        $section = WeddingRoomBlocksSection3::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 3 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $section->id,
                'items' => $section->items ?? []
            ]
        ]);
    }

    // Admin POST endpoint - create new essentials
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Filter out empty items
        $items = array_values(array_filter($request->items, function($item) {
            return trim($item) !== '';
        }));

        $section = WeddingRoomBlocksSection3::create(['items' => $items]);

        return response()->json([
            'success' => true,
            'message' => 'Essentials created successfully',
            'data' => [
                'id' => $section->id,
                'items' => $section->items
            ]
        ]);
    }

    // Admin PUT endpoint - update existing essentials
    public function update(Request $request, $id)
    {
        $section = WeddingRoomBlocksSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Essentials not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Filter out empty items
        $items = array_values(array_filter($request->items, function($item) {
            return trim($item) !== '';
        }));

        $section->update(['items' => $items]);

        return response()->json([
            'success' => true,
            'message' => 'Essentials updated successfully',
            'data' => [
                'id' => $section->id,
                'items' => $section->items
            ]
        ]);
    }

    // Admin DELETE endpoint - delete essentials
    public function destroy($id)
    {
        $section = WeddingRoomBlocksSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Essentials not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Essentials deleted successfully'
        ]);
    }
}