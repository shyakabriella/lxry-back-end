<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingRoomBlocksSection5Controller extends Controller
{
    public function getSection()
    {
        $section = WeddingRoomBlocksSection5::first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'title' => 'Restful Essentials',
                'items' => $section ? $section->items : []
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingRoomBlocksSection5::first();
        
        $data = ['items' => $request->items];
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding room blocks section 5 updated successfully';
        } else {
            $section = WeddingRoomBlocksSection5::create($data);
            $message = 'Wedding room blocks section 5 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'title' => 'Restful Essentials',
                'items' => $section->items
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

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