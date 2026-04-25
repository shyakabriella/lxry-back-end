<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingSlideController extends Controller
{
    // Get all wedding slides (public)
    public function getSlides()
    {
        $slides = WeddingSlide::all();
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Create new wedding slide (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $slide = WeddingSlide::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide created successfully',
            'data' => $slide
        ], 201);
    }

    // Update wedding slide (admin)
    public function update(Request $request, $id)
    {
        $slide = WeddingSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'sometimes|required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $slide->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide updated successfully',
            'data' => $slide
        ]);
    }

    // Delete wedding slide (admin)
    public function destroy($id)
    {
        $slide = WeddingSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding slide not found'
            ], 404);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide deleted successfully'
        ]);
    }
}