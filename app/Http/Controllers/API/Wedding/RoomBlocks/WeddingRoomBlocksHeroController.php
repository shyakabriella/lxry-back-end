<?php

namespace App\Http\Controllers\API\Wedding\RoomBlocks;

use App\Http\Controllers\Controller;
use App\Models\Wedding\RoomBlocks\WeddingRoomBlocksHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingRoomBlocksHeroController extends Controller
{
    public function getHero()
    {
        $hero = WeddingRoomBlocksHero::first();
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks hero not found'
            ], 404);
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hero = WeddingRoomBlocksHero::first();
        
        $data = ['title' => $request->title];
        
        if ($request->hasFile('image')) {
            if ($hero && $hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            $data['background_image'] = $request->file('image')->store('wedding-room-blocks-hero', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $data['background_image'] = $request->image_url;
        }
        
        if ($hero) {
            $hero->update($data);
            $message = 'Wedding room blocks hero updated successfully';
        } else {
            $hero = WeddingRoomBlocksHero::create($data);
            $message = 'Wedding room blocks hero created successfully';
        }

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
        $hero = WeddingRoomBlocksHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks hero not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string',
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

        if ($request->hasFile('image')) {
            if ($hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($hero->background_image);
            }
            $hero->background_image = $request->file('image')->store('wedding-room-blocks-hero', 'public');
        } elseif ($request->has('image_url') && $request->image_url) {
            $hero->background_image = $request->image_url;
        }

        $hero->save();

        $responseData = $hero->fresh()->toArray();
        if ($responseData['background_image'] && !filter_var($responseData['background_image'], FILTER_VALIDATE_URL)) {
            $cleanPath = ltrim($responseData['background_image'], '/');
            $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
            $responseData['background_image'] = asset('storage/' . $cleanPath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks hero updated successfully',
            'data' => $responseData
        ]);
    }

    public function destroy($id)
    {
        $hero = WeddingRoomBlocksHero::find($id);
        
        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding room blocks hero not found'
            ], 404);
        }

        if ($hero->background_image && !filter_var($hero->background_image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($hero->background_image);
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding room blocks hero deleted successfully'
        ]);
    }
}