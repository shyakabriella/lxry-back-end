<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection4Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingSection4AccommodationController extends Controller
{
    // Get wedding section 4 (public)
    public function getSection()
    {
        $section = WeddingSection4Accommodation::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 4 content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update wedding section 4 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url',
            'amenities' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingSection4Accommodation::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding section 4 updated successfully';
        } else {
            $section = WeddingSection4Accommodation::create($request->all());
            $message = 'Wedding section 4 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update wedding section 4 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingSection4Accommodation::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 4 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url',
            'amenities' => 'nullable|array'
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
            'message' => 'Wedding section 4 updated successfully',
            'data' => $section
        ]);
    }

    // Delete wedding section 4 (admin)
    public function destroy($id)
    {
        $section = WeddingSection4Accommodation::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 4 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 4 deleted successfully'
        ]);
    }
}