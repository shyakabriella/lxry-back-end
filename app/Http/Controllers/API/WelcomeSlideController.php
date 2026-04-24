<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WelcomeSlideController extends Controller
{
    // Get all slides (for React frontend)
    public function index()
    {
        $slides = WelcomeSlide::all();
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Get single slide
    public function show($id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $slide
        ]);
    }

    // Create new slide
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $slide = WelcomeSlide::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully',
            'data' => $slide
        ], 201);
    }

    // Update slide
    public function update(Request $request, $id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $slide->update($request->only(['title', 'description', 'image_url']));

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully',
            'data' => $slide
        ]);
    }

    // Delete slide
    public function destroy($id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully'
        ]);
    }
}