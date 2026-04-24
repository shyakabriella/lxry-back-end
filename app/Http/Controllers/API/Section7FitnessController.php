<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section7Fitness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section7FitnessController extends Controller
{
    /**
     * Get fitness section content (for frontend)
     */
    public function getSection()
    {
        $section = Section7Fitness::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update fitness section
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
        $section = Section7Fitness::first();
        
        if ($section) {
            // Update existing
            $section->update($request->all());
            $message = 'Fitness section updated successfully';
        } else {
            // Create new
            $section = Section7Fitness::create($request->all());
            $message = 'Fitness section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ], 200);
    }

    /**
     * Update fitness section
     */
    public function update(Request $request, $id)
    {
        $section = Section7Fitness::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section not found'
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
            'message' => 'Fitness section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Delete fitness section
     */
    public function destroy($id)
    {
        $section = Section7Fitness::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fitness section deleted successfully'
        ]);
    }
}