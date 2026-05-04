<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingPackagesSection2Controller extends Controller
{
    public function getSection()
    {
        $section = WeddingPackagesSection2::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        $data = $section->toArray();
        if ($data['image_url'] && !filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($data['image_url'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $data['image_url'] = asset('storage/' . $cleanPath);
        }

        // Convert features from separate fields to array
        $features = [];
        for ($i = 1; $i <= 10; $i++) {
            $featureKey = "feature{$i}";
            if (!empty($data[$featureKey])) {
                $features[] = $data[$featureKey];
            }
            unset($data[$featureKey]);
        }
        $data['items'] = $features;

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string',
            'items' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $section = WeddingPackagesSection2::first();
        
        $data = ['title' => $request->title];
        
        // Handle image
        if ($request->hasFile('image')) {
            if ($section && $section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('wedding-packages-section2', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['image_url'] = $request->image_url;
        }
        
        // Handle features as separate fields
        $items = $request->items ?? [];
        for ($i = 0; $i < 10; $i++) {
            $featureKey = "feature" . ($i + 1);
            $data[$featureKey] = $items[$i] ?? null;
        }
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding packages section 2 updated successfully';
        } else {
            $section = WeddingPackagesSection2::create($data);
            $message = 'Wedding packages section 2 created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section
        ]);
    }

    public function update(Request $request, $id)
    {
        $section = WeddingPackagesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 2 updated successfully',
            'data' => $section
        ]);
    }

    public function destroy($id)
    {
        $section = WeddingPackagesSection2::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding packages section 2 not found'
            ], 404);
        }

        if ($section->image_url && !filter_var($section->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding packages section 2 deleted successfully'
        ]);
    }
}