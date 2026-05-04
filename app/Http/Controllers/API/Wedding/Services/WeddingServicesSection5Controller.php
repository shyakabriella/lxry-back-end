<?php

namespace App\Http\Controllers\API\Wedding\Services;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Services\WeddingServicesSection5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingServicesSection5Controller extends Controller
{
    // Get section 5 (public) - returns items with static title/subtitle
    public function getSection()
    {
        $section = WeddingServicesSection5::first();
        
        $response = [
            'success' => true,
            'data' => [
                'title' => 'What You Get at',
                'subtitle' => 'Luxury Garden Palace',
                'items' => $section ? $section->items : []
            ]
        ];

        return response()->json($response);
    }

    // Create or update items only (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingServicesSection5::first();
        
        if ($section) {
            $section->update(['items' => $request->items]);
            $message = 'Wedding services section 5 updated successfully';
        } else {
            $section = WeddingServicesSection5::create(['items' => $request->items]);
            $message = 'Wedding services section 5 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'title' => 'What You Get at',
                'subtitle' => 'Luxury Garden Palace',
                'items' => $section->items
            ]
        ]);
    }

    // Update items only (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingServicesSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 5 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section->update(['items' => $request->items]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 5 updated successfully',
            'data' => [
                'title' => 'What You Get at',
                'subtitle' => 'Luxury Garden Palace',
                'items' => $section->items
            ]
        ]);
    }

    // Delete section 5 (admin)
    public function destroy($id)
    {
        $section = WeddingServicesSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services section 5 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding services section 5 deleted successfully'
        ]);
    }
}