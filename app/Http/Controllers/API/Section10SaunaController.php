<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section10Sauna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section10SaunaController extends Controller
{
    /**
     * Get sauna section (for frontend)
     */
    public function getSection()
    {
        $section = Section10Sauna::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Sauna section content not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    /**
     * Create or update everything (content + images)
     * This ONE method handles both CREATE and UPDATE
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if record exists
        $section = Section10Sauna::first();
        
        if ($section) {
            // UPDATE existing record
            $section->update($request->all());
            $message = 'Sauna section updated successfully';
        } else {
            // CREATE new record
            $section = Section10Sauna::create($request->all());
            $message = 'Sauna section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    /**
     * Delete sauna section
     */
    public function destroy($id)
    {
        $section = Section10Sauna::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Sauna section not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sauna section deleted successfully'
        ]);
    }
}