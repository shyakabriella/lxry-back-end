<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingPackagesSection2Controller extends Controller
{
    // Get section 2 (public)
    public function getSection()
    {
        $section = WeddingPackagesSection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Create or update section 2 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'feature1' => 'nullable|string',
            'feature2' => 'nullable|string',
            'feature3' => 'nullable|string',
            'feature4' => 'nullable|string',
            'feature5' => 'nullable|string',
            'feature6' => 'nullable|string',
            'feature7' => 'nullable|string',
            'feature8' => 'nullable|string',
            'feature9' => 'nullable|string',
            'feature10' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingPackagesSection2::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding packages section 2 updated successfully';
        } else {
            $section = WeddingPackagesSection2::create($request->all());
            $message = 'Wedding packages section 2 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    // Update section 2 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingPackagesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 2 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 2 (admin)
    public function destroy($id)
    {
        $section = WeddingPackagesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 2 deleted successfully'
        ]);
    }
}