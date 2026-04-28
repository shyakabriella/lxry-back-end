<?php

namespace App\Http\Controllers\Api\Wedding\Venues;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Venues\WeddingVenuesHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return response()->json([
            'success' => true,
            'data' => $hero
        ]);
    }

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

        $hero = WeddingVenuesHero::first();
        
        if ($hero) {
            $hero->update($request->all());
            $message = 'Wedding venues hero updated successfully';
        } else {
            $hero = WeddingVenuesHero::create($request->all());
            $message = 'Wedding venues hero created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $hero
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
            'message' => 'Wedding venues hero updated successfully',
            'data' => $hero
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

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding venues hero deleted successfully'
        ]);
    }
}