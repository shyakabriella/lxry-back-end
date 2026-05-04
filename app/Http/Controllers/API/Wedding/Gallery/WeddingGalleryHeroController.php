<?php

namespace App\Http\Controllers\API\Wedding\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Gallery\WeddingGalleryHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingGalleryHeroController extends Controller
{
    // Get hero (public)
    public function getHero()
    {
        $hero = WeddingGalleryHero::first();
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery hero not found'
            ], 404);
        }

        // Convert background_image to full URL
        if ($hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
            $hero->background_image = asset('storage/' . ltrim($hero->background_image, '/'));
        }

        return response()->json([
            'success' => true,
            'data' => $hero
        ]);
    }

    // Create or update hero (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
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

        $hero = WeddingGalleryHero::first();
        
        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle ?? null,
            'description' => $request->description ?? null,
        ];
        
        // Handle image upload - following your pattern
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($hero && $hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            // Store new image
            $path = $request->file('image')->store('wedding-gallery-hero', 'public');
            $data['background_image'] = $path;
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['background_image'] = $request->image_url;
        }
        
        if ($hero) {
            $hero->update($data);
            $message = 'Wedding gallery hero updated successfully';
        } else {
            $hero = WeddingGalleryHero::create($data);
            $message = 'Wedding gallery hero created successfully';
        }

        // Return with full URL - following your pattern
        $responseData = $hero->toArray();
        if ($responseData['background_image'] && !filter_var($responseData['background_image'], FILTER_VALIDATE_URL)) {
            $responseData['background_image'] = asset('storage/' . ltrim($responseData['background_image'], '/'));
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $responseData
        ]);
    }

    // Update hero (admin)
    public function update(Request $request, $id)
    {
        $hero = WeddingGalleryHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery hero not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string',
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

        // Update basic fields - following your pattern
        if ($request->has('title')) {
            $hero->title = $request->title;
        }
        if ($request->has('subtitle')) {
            $hero->subtitle = $request->subtitle;
        }
        if ($request->has('description')) {
            $hero->description = $request->description;
        }

        // Handle image upload - following your pattern
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            // Store new image
            $hero->background_image = $request->file('image')->store('wedding-gallery-hero', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $hero->background_image = $request->image_url;
        }

        $hero->save();

        // Return with full URL - following your pattern
        $responseData = $hero->toArray();
        if ($responseData['background_image'] && !filter_var($responseData['background_image'], FILTER_VALIDATE_URL)) {
            $responseData['background_image'] = asset('storage/' . ltrim($responseData['background_image'], '/'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery hero updated successfully',
            'data' => $responseData
        ]);
    }

    // Delete hero (admin)
    public function destroy($id)
    {
        $hero = WeddingGalleryHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding gallery hero not found'
            ], 404);
        }

        // Delete image from storage - following your pattern
        if ($hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($hero->background_image);
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery hero deleted successfully'
        ]);
    }
}