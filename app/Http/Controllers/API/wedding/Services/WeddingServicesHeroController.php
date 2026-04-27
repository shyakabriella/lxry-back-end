<?php

namespace App\Http\Controllers\API\Wedding\Services;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Services\WeddingServicesHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingServicesHeroController extends Controller
{
    // Get hero (public)
    public function getHero()
    {
        $hero = WeddingServicesHero::first();
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services hero not found'
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
            'background_image' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hero = WeddingServicesHero::first();
        
        if ($hero) {
            $hero->update($request->all());
            $message = 'Wedding services hero updated successfully';
        } else {
            $hero = WeddingServicesHero::create($request->all());
            $message = 'Wedding services hero created successfully';
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
        $hero = WeddingServicesHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services hero not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
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
            'message' => 'Wedding services hero updated successfully',
            'data' => $hero
        ]);
    }

    // Delete hero (admin)
    public function destroy($id)
    {
        $hero = WeddingServicesHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding services hero not found'
            ], 404);
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding services hero deleted successfully'
        ]);
    }
}