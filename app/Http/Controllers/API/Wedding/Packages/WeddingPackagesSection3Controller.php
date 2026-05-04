<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingPackagesSection3Controller extends Controller
{
    // Get section 3 (public)
    public function getSection()
    {
        $section = WeddingPackagesSection3::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 3 not found'
            ], 404);
        }

        // Convert image path to full URL
        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            $section->image_url = asset('storage/' . ltrim($section->image_url, '/'));
        }

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // Store section 3 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'items' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'items' => $request->items ?? [],
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('wedding-packages-section3', 'public');
            $data['image_url'] = $path;
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['image_url'] = $request->image_url;
        }
        
        $section = WeddingPackagesSection3::create($data);

        // Return with full URL
        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            $section->image_url = asset('storage/' . ltrim($section->image_url, '/'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 3 created successfully',
            'data' => $section
        ]);
    }

    // Update section 3 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingPackagesSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 3 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'items' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('title')) {
            $section->title = $request->title;
        }
        
        if ($request->has('items')) {
            $section->items = $request->items;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $path = $request->file('image')->store('wedding-packages-section3', 'public');
            $section->image_url = $path;
        } elseif ($request->has('image_url') && $request->image_url) {
            $section->image_url = $request->image_url;
        }

        $section->save();

        // Return with full URL
        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            $section->image_url = asset('storage/' . ltrim($section->image_url, '/'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 3 updated successfully',
            'data' => $section
        ]);
    }

    // Delete section 3 (admin)
    public function destroy($id)
    {
        $section = WeddingPackagesSection3::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 3 not found'
            ], 404);
        }

        // Delete image from storage
        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 3 deleted successfully'
        ]);
    }
}