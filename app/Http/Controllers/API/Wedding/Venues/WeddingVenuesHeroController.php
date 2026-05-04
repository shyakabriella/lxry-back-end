<?php

namespace App\Http\Controllers\Api\Wedding\Venues;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Venues\WeddingVenuesHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingVenuesHeroController extends Controller
{
    public function getHero()
    {
        $hero = WeddingVenuesHero::first();
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues hero not found'
            ], 404);
        }

        // Convert stored path to full URL
        $data = $hero->toArray();
        if ($data['background_image'] && !filter_var($data['background_image'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($data['background_image'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $data['background_image'] = asset('storage/' . $cleanPath);
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
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hero = WeddingVenuesHero::first();
        
        $data = [
            'title' => $request->title,
        ];
        
        // Handle image upload
        if ($request->hasFile('background_image')) {
            $imagePath = $request->file('background_image')->store('wedding-venues-hero', 'public');
            $data['background_image'] = $imagePath;
        }
        
        if ($hero) {
            // Delete old image if exists
            if ($hero->background_image && Storage::disk('public')->exists($hero->background_image)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            $hero->update($data);
            $message = 'Wedding venues hero updated successfully';
        } else {
            $hero = WeddingVenuesHero::create($data);
            $message = 'Wedding venues hero created successfully';
        }

        // Return full URL in response
        $responseData = $hero->toArray();
        if ($responseData['background_image'] && !filter_var($responseData['background_image'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['background_image'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['background_image'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $responseData
        ]);
    }

    public function update(Request $request, $id)
    {
        $hero = WeddingVenuesHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues hero not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('title')) {
            $hero->title = $request->title;
        }

        // Handle image upload
        if ($request->hasFile('background_image')) {
            // Delete old image
            if ($hero->background_image && Storage::disk('public')->exists($hero->background_image)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            $hero->background_image = $request->file('background_image')->store('wedding-venues-hero', 'public');
        }

        $hero->save();

        // Return full URL in response
        $responseData = $hero->fresh()->toArray();
        if ($responseData['background_image'] && !filter_var($responseData['background_image'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['background_image'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['background_image'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues hero updated successfully',
            'data' => $responseData
        ]);
    }

    public function destroy($id)
    {
        $hero = WeddingVenuesHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding venues hero not found'
            ], 404);
        }

        // Delete associated image
        if ($hero->background_image && Storage::disk('public')->exists($hero->background_image)) {
            Storage::disk('public')->delete($hero->background_image);
        }
        
        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues hero deleted successfully'
        ]);
    }
}