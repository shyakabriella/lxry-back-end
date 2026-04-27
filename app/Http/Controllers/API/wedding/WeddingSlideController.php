<?php

namespace App\Http\Controllers\API\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingSlideController extends Controller
{
    // Get all slides (public)
    public function getSlides()
    {
        $slides = WeddingSlide::orderBy('sort_order', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Create new slide with image upload
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120', // 5MB max
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file upload - like Multer in Node.js
        $image = $request->file('image');
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store the file in storage/app/public/wedding-slides
        $path = $image->storeAs('wedding-slides', $filename, 'public');
        
        // $path will be something like: "wedding-slides/1734567890_abc123.jpg"

        $slide = WeddingSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image_url' => $path, // Store the path, not the full URL
            'sort_order' => $request->sort_order ?? 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide created successfully',
            'data' => $slide
        ], 201);
    }

    // Update slide with optional new image
    public function update(Request $request, $id)
    {
        $slide = WeddingSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title ?? $slide->title,
            'subtitle' => $request->subtitle ?? $slide->subtitle,
            'description' => $request->description ?? $slide->description,
            'sort_order' => $request->sort_order ?? $slide->sort_order
        ];

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image file
            if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
                Storage::disk('public')->delete($slide->image_url);
            }
            
            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('wedding-slides', $filename, 'public');
            $data['image_url'] = $path;
        }

        $slide->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide updated successfully',
            'data' => $slide
        ]);
    }

    // Delete slide and its image file
    public function destroy($id)
    {
        $slide = WeddingSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        // Delete the image file from storage
        if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
            Storage::disk('public')->delete($slide->image_url);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding slide deleted successfully'
        ]);
    }
}