<?php

namespace App\Http\Controllers\API\Wedding\Services;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Services\WeddingServicesSection3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingServicesSection3Controller extends Controller
{
    // Get section 3 (public)
    public function getSection()
    {
        $section = WeddingServicesSection3::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 3 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update section 3 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'card1_title' => 'required|string|max:255',
            'card1_description' => 'required|string',
            'card1_image' => 'required|url',
            'card2_title' => 'required|string|max:255',
            'card2_description' => 'required|string',
            'card2_image' => 'required|url',
            'card1_subtitle' => 'nullable|string',
            'card2_subtitle' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingServicesSection3::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding services section 3 updated successfully';
        } else {
            $section = WeddingServicesSection3::create($request->all());
            $message = 'Wedding services section 3 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update section 3 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingServicesSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 3 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 3 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 3 (admin)
    public function destroy($id)
    {
        $section = WeddingServicesSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 3 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 3 deleted successfully'
        ]);
    }
}