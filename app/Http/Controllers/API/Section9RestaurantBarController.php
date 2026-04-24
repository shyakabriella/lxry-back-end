<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section9RestaurantBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section9RestaurantBarController extends Controller
{
    /**
     * Get restaurant & bar section content (for frontend)
     */
    public function getSection()
    {
        $section = Section9RestaurantBar::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant & Bar section content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update restaurant & bar section
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
        $section = Section9RestaurantBar::first();
        
        if ($section) {
            // Update existing
            $section->update($request->all());
            $message = 'Restaurant & Bar section updated successfully';
        } else {
            // Create new
            $section = Section9RestaurantBar::create($request->all());
            $message = 'Restaurant & Bar section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ], 200);
    }

    /**
     * Update restaurant & bar section
     */
    public function update(Request $request, $id)
    {
        $section = Section9RestaurantBar::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant & Bar section not found'
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
            'message' => 'Restaurant & Bar section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Delete restaurant & bar section
     */
    public function destroy($id)
    {
        $section = Section9RestaurantBar::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant & Bar section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Restaurant & Bar section deleted successfully'
        ]);
    }
}