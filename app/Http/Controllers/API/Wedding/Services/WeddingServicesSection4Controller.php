<?php

namespace App\Http\Controllers\API\Wedding\Services;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Services\WeddingServicesSection4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingServicesSection4Controller extends Controller
{
    // Get section 4 (public)
    public function getSection()
    {
        $section = WeddingServicesSection4::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 4 not found'
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
            'card1_title' => 'required|string|max:255',
            'card1_description' => 'required|string',
            'card2_title' => 'required|string|max:255',
            'card2_description' => 'required|string',
            'card3_title' => 'required|string|max:255',
            'card3_description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingServicesSection4::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding services section 4 updated successfully';
        } else {
            $section = WeddingServicesSection4::create($request->all());
            $message = 'Wedding services section 4 created successfully';
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
        $section = WeddingServicesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 4 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 4 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 4 (admin)
    public function destroy($id)
    {
        $section = WeddingServicesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 4 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 4 deleted successfully'
        ]);
    }
}