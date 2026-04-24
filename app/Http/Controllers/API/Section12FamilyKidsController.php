<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section12FamilyKids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section12FamilyKidsController extends Controller
{
    /**
     * Get family & kids section content (for frontend)
     */
    public function getSection()
    {
        $section = Section12FamilyKids::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Family & Kids section content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update family & kids section
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
        $section = Section12FamilyKids::first();
        
        if ($section) {
            // Update existing
            $section->update($request->all());
            $message = 'Family & Kids section updated successfully';
        } else {
            // Create new
            $section = Section12FamilyKids::create($request->all());
            $message = 'Family & Kids section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    /**
     * Update family & kids section
     */
    public function update(Request $request, $id)
    {
        $section = Section12FamilyKids::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Family & Kids section not found'
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
            'message' => 'Family & Kids section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Delete family & kids section
     */
    public function destroy($id)
    {
        $section = Section12FamilyKids::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Family & Kids section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Family & Kids section deleted successfully'
        ]);
    }
}