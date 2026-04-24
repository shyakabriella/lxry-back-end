<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section5Luxury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section5LuxuryController extends Controller
{
    /**
     * Get section 5 content (for frontend)
     */
    public function getSection()
    {
        $section = Section5Luxury::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section 5 content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update section 5 content
     */
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

        // Check if content already exists
        $section = Section5Luxury::first();
        
        if ($section) {
            // Update existing
            $section->update($request->all());
            $message = 'Section 5 content updated successfully';
        } else {
            // Create new
            $section = Section5Luxury::create($request->all());
            $message = 'Section 5 content created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ], 200);
    }

    /**
     * Update section 5 content
     */
    public function update(Request $request, $id)
    {
        $section = Section5Luxury::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section 5 content not found'
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
            'message' => 'Section 5 content updated successfully',
            'data' => $section
        ]);
    }
}