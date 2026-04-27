<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingPackagesSection4Controller extends Controller
{
    // Get section 4 (public)
    public function getSection()
    {
        $section = WeddingPackagesSection4::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 4 not found'
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
            'title' => 'nullable|string|max:255',
            'benefit1' => 'nullable|string',
            'benefit2' => 'nullable|string',
            'benefit3' => 'nullable|string',
            'benefit4' => 'nullable|string',
            'benefit5' => 'nullable|string',
            'benefit6' => 'nullable|string',
            'benefit7' => 'nullable|string',
            'benefit8' => 'nullable|string',
            'benefit9' => 'nullable|string',
            'benefit10' => 'nullable|string',
            'benefit11' => 'nullable|string',
            'benefit12' => 'nullable|string',
            'benefit13' => 'nullable|string',
            'benefit14' => 'nullable|string',
            'benefit15' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingPackagesSection4::first();
        
        if ($section) {
            $section->update($request->all());
            $message = 'Wedding packages section 4 updated successfully';
        } else {
            $section = WeddingPackagesSection4::create($request->all());
            $message = 'Wedding packages section 4 created successfully';
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
        $section = WeddingPackagesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 4 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 4 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 4 (admin)
    public function destroy($id)
    {
        $section = WeddingPackagesSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 4 not found'
            ], 404);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 4 deleted successfully'
        ]);
    }
}