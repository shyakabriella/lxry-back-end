<?php

namespace App\Http\Controllers\API\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection3Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WeddingSection3ApartmentController extends Controller
{
    public function getSection()
    {
        try {
            $section = WeddingSection3Apartment::first();
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding section 3 content not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $section
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'image_url' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $imagePath = null;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('wedding-section3', $filename, 'public');
            } elseif ($request->has('image_url') && $request->image_url) {
                $imagePath = $request->image_url;
            }

            $section = WeddingSection3Apartment::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'image_url' => $imagePath,
                'amenities' => []
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Wedding section 3 created successfully',
                'data' => $section
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $section = WeddingSection3Apartment::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding section 3 not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'subtitle' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'image_url' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->has('title')) $section->title = $request->title;
            if ($request->has('subtitle')) $section->subtitle = $request->subtitle;
            if ($request->has('description')) $section->description = $request->description;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                    Storage::disk('public')->delete($section->image_url);
                }
                
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('wedding-section3', $filename, 'public');
                $section->image_url = $imagePath;
            } elseif ($request->has('image_url') && $request->image_url) {
                $section->image_url = $request->image_url;
            }

            $section->save();

            return response()->json([
                'success' => true,
                'message' => 'Wedding section 3 updated successfully',
                'data' => $section
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $section = WeddingSection3Apartment::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding section 3 not found'
                ], 404);
            }

            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wedding section 3 deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}