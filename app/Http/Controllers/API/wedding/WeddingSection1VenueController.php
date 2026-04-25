<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection1Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingSection1VenueController extends Controller
{
    // Get wedding section 1 (public)
    public function getSection()
    {
        $section = WeddingSection1Venue::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update wedding section 1 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingSection1Venue::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding section 1 updated successfully';
        } else {
            $section = WeddingSection1Venue::create($request->all());
            $message = 'Wedding section 1 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update wedding section 1 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingSection1Venue::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'images' => 'sometimes|required|array|min:1',
            'images.*' => 'required|url'
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
            'message' => 'Wedding section 1 updated successfully',
            'data' => $section
        ]);
    }

    // Delete wedding section 1 (admin)
    public function destroy($id)
    {
        $section = WeddingSection1Venue::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 1 deleted successfully'
        ]);
    }
}