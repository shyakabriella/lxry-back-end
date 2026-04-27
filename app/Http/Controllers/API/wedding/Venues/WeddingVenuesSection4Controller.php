<?php

namespace App\Http\Controllers\API\Wedding\Venues;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Venues\WeddingVenuesSection4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingVenuesSection4Controller extends Controller
{
    // Get section 4 (public)
    public function getSection()
    {
        $section = WeddingVenuesSection4::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 4 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update section 4 (admin)
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

        $section = WeddingVenuesSection4::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding venues section 4 updated successfully';
        } else {
            $section = WeddingVenuesSection4::create($request->all());
            $message = 'Wedding venues section 4 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update section 4 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingVenuesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 4 not found'
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
            'message' => 'Wedding venues section 4 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 4 (admin)
    public function destroy($id)
    {
        $section = WeddingVenuesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 4 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues section 4 deleted successfully'
        ]);
    }
}