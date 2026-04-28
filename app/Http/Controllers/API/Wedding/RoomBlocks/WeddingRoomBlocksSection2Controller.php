<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingRoomBlocksSection2Controller extends Controller
{
    // Get section 2 (public)
    public function getSection()
    {
        $section = WeddingRoomBlocksSection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 2 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update section 2 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingRoomBlocksSection2::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding room blocks section 2 updated successfully';
        } else {
            $section = WeddingRoomBlocksSection2::create($request->all());
            $message = 'Wedding room blocks section 2 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update section 2 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingRoomBlocksSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 2 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 2 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 2 (admin)
    public function destroy($id)
    {
        $section = WeddingRoomBlocksSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 2 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 2 deleted successfully'
        ]);
    }
}   