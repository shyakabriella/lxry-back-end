<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingRoomBlocksSection5Controller extends Controller
{
    // Get section 5 (public) - returns amenities with title
    public function getSection()
    {
        $section = WeddingRoomBlocksSection5::first();
        
        $response = [
            'success' => true,
            'data' => [
                'title' => 'Restful Essentials',
                'amenities' => $section ? $section->amenities : []
            ]
        ];

        return response()->json($response);
    }

    // Create or update section 5 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingRoomBlocksSection5::first();
        
        if ($section) {
            $section->update(['amenities' => $request->amenities]);
            $message = 'Wedding room blocks section 5 updated successfully';
        } else {
            $section = WeddingRoomBlocksSection5::create(['amenities' => $request->amenities]);
            $message = 'Wedding room blocks section 5 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'title' => 'Restful Essentials',
                'amenities' => $section->amenities
            ]
        ]);
    }

    // Update section 5 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingRoomBlocksSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 5 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section->update(['amenities' => $request->amenities]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 5 updated successfully',
            'data' => [
                'title' => 'Restful Essentials',
                'amenities' => $section->amenities
            ]
        ]);
    }

    // Delete section 5 (admin)
    public function destroy($id)
    {
        $section = WeddingRoomBlocksSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 5 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 5 deleted successfully'
        ]);
    }
}