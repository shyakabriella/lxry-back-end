<?php

namespace App\Http\Controllers\API\Wedding\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Gallery\WeddingGalleryHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hero = WeddingGalleryHero::first();
        
        if ($hero) {
            $hero->update($request->all());
            $message = 'Wedding gallery hero updated successfully';
        } else {
            $hero = WeddingGalleryHero::create($request->all());
            $message = 'Wedding gallery hero created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $hero
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
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'sometimes|required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hero->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery hero updated successfully',
            'data' => $hero
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

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding gallery hero deleted successfully'
        ]);
    }
}