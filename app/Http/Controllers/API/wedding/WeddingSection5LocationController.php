<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection5Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingSection5LocationController extends Controller
{
    // Get wedding section 5 (public)
    public function getSection()
    {
        $section = WeddingSection5Location::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update wedding section 5 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url',
            'features' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingSection5Location::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding section 5 updated successfully';
        } else {
            $section = WeddingSection5Location::create($request->all());
            $message = 'Wedding section 5 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update wedding section 5 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingSection5Location::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url',
            'features' => 'nullable|array'
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
            'message' => 'Wedding section 5 updated successfully',
            'data' => $section
        ]);
    }

    // Delete wedding section 5 (admin)
    public function destroy($id)
    {
        $section = WeddingSection5Location::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 5 deleted successfully'
        ]);
    }
}