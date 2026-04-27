<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection2EasyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingSection2EasyPlanController extends Controller
{
    // Get all active slides (public)
    public function getSlides()
    {
        $slides = WeddingSection2EasyPlan::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        // Process image URLs
        $slides->transform(function ($slide) {
            if ($slide->image_url && !filter_var($slide->image_url, FILTER_VALIDATE_URL)) {
                $slide->image_url = asset('storage/' . $slide->image_url);
            }
            return $slide;
        });
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Get all slides (admin)
    public function index()
    {
        $slides = WeddingSection2EasyPlan::orderBy('display_order')->get();
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Get single slide
    public function show($id)
    {
        $slide = WeddingSection2EasyPlan::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        if ($slide->image_url && !filter_var($slide->image_url, FILTER_VALIDATE_URL)) {
            $slide->image_url = asset('storage/' . $slide->image_url);
        }

        return response()->json([
            'success' => true,
            'data' => $slide
        ]);
    }

    // Create new slide (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'display_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle image upload
        $imagePath = $request->file('image')->store('wedding-section2', 'public');

        $maxOrder = WeddingSection2EasyPlan::max('display_order') ?? 0;

        $slide = WeddingSection2EasyPlan::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image_url' => $imagePath,
            'display_order' => $request->display_order ?? $maxOrder + 1,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully',
            'data' => $slide
        ], 201);
    }

    // Update slide (admin)
    public function update(Request $request, $id)
    {
        $slide = WeddingSection2EasyPlan::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'display_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'display_order' => $request->display_order ?? $slide->display_order
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
                Storage::disk('public')->delete($slide->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-section2', 'public');
        }

        $slide->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully',
            'data' => $slide
        ]);
    }

    // Delete slide (admin)
    public function destroy($id)
    {
        $slide = WeddingSection2EasyPlan::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        // Delete image file
        if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
            Storage::disk('public')->delete($slide->image_url);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully'
        ]);
    }
}