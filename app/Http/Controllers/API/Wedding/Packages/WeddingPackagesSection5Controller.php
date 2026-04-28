<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingPackagesSection5Controller extends Controller
{
    // Get section 5 (public)
    public function getSection()
    {
        $section = WeddingPackagesSection5::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 5 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update section 5 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'block1_title' => 'nullable|string',
            'block1_image' => 'nullable|url',
            'block1_item1' => 'nullable|string',
            'block1_item2' => 'nullable|string',
            'block1_item3' => 'nullable|string',
            'block1_item4' => 'nullable|string',
            'block2_title' => 'nullable|string',
            'block2_image' => 'nullable|url',
            'block2_item1' => 'nullable|string',
            'block2_item2' => 'nullable|string',
            'block2_item3' => 'nullable|string',
            'block2_item4' => 'nullable|string',
            'block3_title' => 'nullable|string',
            'block3_image' => 'nullable|url',
            'block3_item1' => 'nullable|string',
            'block3_item2' => 'nullable|string',
            'block3_item3' => 'nullable|string',
            'block3_item4' => 'nullable|string',
            'block4_title' => 'nullable|string',
            'block4_image' => 'nullable|url',
            'block4_item1' => 'nullable|string',
            'block4_item2' => 'nullable|string',
            'block4_item3' => 'nullable|string',
            'block4_item4' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingPackagesSection5::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding packages section 5 updated successfully';
        } else {
            $section = WeddingPackagesSection5::create($request->all());
            $message = 'Wedding packages section 5 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update section 5 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingPackagesSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 5 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 5 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 5 (admin)
    public function destroy($id)
    {
        $section = WeddingPackagesSection5::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 5 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 5 deleted successfully'
        ]);
    }
}