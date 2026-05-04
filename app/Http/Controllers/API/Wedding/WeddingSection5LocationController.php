<?php

namespace App\Http\Controllers\Api\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection5Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingSection5LocationController extends Controller
{
    // Get wedding section 5 (public) - Returns full URLs
    public function getSection()
    {
        $section = WeddingSection5Location::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 content not found'
            ], 404);
        }

        $data = $section->toArray();
        
        // Convert stored path to full URL using asset() instead of Storage::url()
        if ($data['image_url'] && !filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
            // Remove any leading slashes or storage prefix
            $cleanPath = ltrim($data['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            // Use asset() to generate full URL
            $data['image_url'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Create or update (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingSection5Location::first();
        
        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ];
        
        // Handle image - store only the path
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($section && $section->image_url) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-section5', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            // If user entered a full URL, store it as is (for external images)
            $data['image_url'] = $request->image_url;
        }
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding section 5 updated successfully';
        } else {
            $section = WeddingSection5Location::create($data);
            $message = 'Wedding section 5 created successfully';
        }

        // Return full URL for response
        $responseData = $section->toArray();
        if ($responseData['image_url'] && !filter_var($responseData['image_url'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['image_url'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $responseData
        ]);
    }

    // Update (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingSection5Location::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];
        
        if ($request->has('title')) $data['title'] = $request->title;
        if ($request->has('subtitle')) $data['subtitle'] = $request->subtitle;
        if ($request->has('description')) $data['description'] = $request->description;
        
        // Handle image
        if ($request->hasFile('image')) {
            if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-section5', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['image_url'] = $request->image_url;
        }

        $section->update($data);

        // Return full URL for response
        $responseData = $section->fresh()->toArray();
        if ($responseData['image_url'] && !filter_var($responseData['image_url'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['image_url'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 5 updated successfully',
            'data' => $responseData
        ]);
    }

    // Delete (admin)
    public function destroy($id)
    {
        $section = WeddingSection5Location::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 5 not found'
            ], 404);
        }

        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 5 deleted successfully'
        ]);
    }
}