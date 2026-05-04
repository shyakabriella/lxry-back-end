<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksSection4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingRoomBlocksSection4Controller extends Controller
{
    // Get section 4 (public)
    public function getSection()
    {
        $section = WeddingRoomBlocksSection4::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 4 not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $section->id,
                'title' => $section->title ?? '',
                'subtitle' => $section->subtitle ?? '',
                'description' => $section->description ?? '',
                'image_url' => $section->image_url ?? ''
            ]
        ]);
    }

    // Store section 4 (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingRoomBlocksSection4::first();
        
        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle ?? '',
            'description' => $request->description ?? '',
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            if ($section && $section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-room-blocks-section4', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['image_url'] = $request->image_url;
        }
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding room blocks section 4 updated successfully';
        } else {
            $section = WeddingRoomBlocksSection4::create($data);
            $message = 'Wedding room blocks section 4 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'id' => $section->id,
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'image_url' => $section->image_url
            ]
        ]);
    }

    // Update section 4 (admin)
    public function update(Request $request, $id)
    {
        $section = WeddingRoomBlocksSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 4 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
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
        if ($request->has('subtitle')) {
            $section->subtitle = $request->subtitle;
        }
        if ($request->has('description')) {
            $section->description = $request->description;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $section->image_url = $request->file('image')->store('wedding-room-blocks-section4', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $section->image_url = $request->image_url;
        }

        $section->save();

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 4 updated successfully',
            'data' => [
                'id' => $section->id,
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'image_url' => $section->image_url
            ]
        ]);
    }

    // Delete section 4 (admin)
    public function destroy($id)
    {
        $section = WeddingRoomBlocksSection4::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks section 4 not found'
            ], 404);
        }

        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks section 4 deleted successfully'
        ]);
    }
}