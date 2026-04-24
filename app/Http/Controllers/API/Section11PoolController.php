<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section11Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section11PoolController extends Controller
{
    /**
     * Get pool section content (for frontend)
     */
    public function getSection()
    {
        $section = Section11Pool::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update pool section
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
        $section = Section11Pool::first();
        
        if ($section) {
            // Update existing
            $section->update($request->all());
            $message = 'Pool section updated successfully';
        } else {
            // Create new
            $section = Section11Pool::create($request->all());
            $message = 'Pool section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    /**
     * Update pool section
     */
    public function update(Request $request, $id)
    {
        $section = Section11Pool::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section not found'
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
            'message' => 'Pool section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Delete pool section
     */
    public function destroy($id)
    {
        $section = Section11Pool::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pool section deleted successfully'
        ]);
    }
}