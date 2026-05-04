<?php

namespace App\Http\Controllers\API\Wedding\Venues;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Venues\WeddingVenuesSection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingVenuesSection2Controller extends Controller
{
    public function getSection()
    {
        $section = WeddingVenuesSection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 2 not found'
            ], 404);
        }

        $data = $section->toArray();
        if ($data['image_url'] && !filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($data['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $data['image_url'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

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

        $section = WeddingVenuesSection2::first();
        
        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ];
        
        if ($request->hasFile('image')) {
            if ($section && $section->image_url) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-venues-section2', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['image_url'] = $request->image_url;
        }
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding venues section 2 updated successfully';
        } else {
            $section = WeddingVenuesSection2::create($data);
            $message = 'Wedding venues section 2 created successfully';
        }

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

    public function update(Request $request, $id)
    {
        $section = WeddingVenuesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 2 not found'
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

        if ($request->has('title')) $section->title = $request->title;
        if ($request->has('subtitle')) $section->subtitle = $request->subtitle;
        if ($request->has('description')) $section->description = $request->description;

        if ($request->hasFile('image')) {
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $section->image_url = $request->file('image')->store('wedding-venues-section2', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $section->image_url = $request->image_url;
        }

        $section->save();

        $responseData = $section->fresh()->toArray();
        if ($responseData['image_url'] && !filter_var($responseData['image_url'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['image_url'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues section 2 updated successfully',
            'data' => $responseData
        ]);
    }

    public function destroy($id)
    {
        $section = WeddingVenuesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues section 2 not found'
            ], 404);
        }

        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues section 2 deleted successfully'
        ]);
    }
}