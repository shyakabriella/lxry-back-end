<?php

namespace App\Http\Controllers\API\Wedding\Services;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Services\WeddingServicesSection3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WeddingServicesSection3Controller extends Controller
{
    public function getSection()
    {
        try {
            $section = WeddingServicesSection3::first();
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding services section 3 not found'
                ], 404);
            }

            $data = $section->toArray();
            
            foreach (['card1_image', 'card2_image'] as $imageField) {
                if (isset($data[$imageField]) && $data[$imageField] && !filter_var($data[$imageField], FILTER_VALIDATE_URL)) {
                    $data[$imageField] = asset('storage/' . ltrim($data[$imageField], '/'));
                }
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getSection: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'card1_title' => 'required|string|max:255',
                'card1_description' => 'required|string',
                'card2_title' => 'required|string|max:255',
                'card2_description' => 'required|string',
                'card1_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
                'card2_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
                'card1_image_url' => 'nullable|string',
                'card2_image_url' => 'nullable|string',
                'card1_subtitle' => 'nullable|string',
                'card2_subtitle' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $section = WeddingServicesSection3::first();
            
            $data = [
                'title' => $request->title,
                'card1_title' => $request->card1_title,
                'card1_description' => $request->card1_description,
                'card2_title' => $request->card2_title,
                'card2_description' => $request->card2_description,
                'card1_subtitle' => $request->card1_subtitle,
                'card2_subtitle' => $request->card2_subtitle,
            ];
            
            // Handle Card 1 Image - Store ONLY RELATIVE PATH
            if ($request->hasFile('card1_image')) {
                // Delete old image if exists (only if it's a relative path)
                if ($section && $section->card1_image && !filter_var($section->card1_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->card1_image);
                }
                $data['card1_image'] = $request->file('card1_image')->store('wedding-services-section3', 'public');
            } elseif ($request->has('card1_image_url') && $request->card1_image_url) {
                // Extract relative path from full URL if needed
                $url = $request->card1_image_url;
                if (str_contains($url, '/storage/')) {
                    $path = substr($url, strpos($url, '/storage/') + 9);
                    $data['card1_image'] = $path;
                } else {
                    $data['card1_image'] = $url;
                }
            }
            
            // Handle Card 2 Image - Store ONLY RELATIVE PATH
            if ($request->hasFile('card2_image')) {
                // Delete old image if exists (only if it's a relative path)
                if ($section && $section->card2_image && !filter_var($section->card2_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->card2_image);
                }
                $data['card2_image'] = $request->file('card2_image')->store('wedding-services-section3', 'public');
            } elseif ($request->has('card2_image_url') && $request->card2_image_url) {
                // Extract relative path from full URL if needed
                $url = $request->card2_image_url;
                if (str_contains($url, '/storage/')) {
                    $path = substr($url, strpos($url, '/storage/') + 9);
                    $data['card2_image'] = $path;
                } else {
                    $data['card2_image'] = $url;
                }
            }
            
            if ($section) {
                $section->update($data);
                $message = 'Wedding services section 3 updated successfully';
            } else {
                $section = WeddingServicesSection3::create($data);
                $message = 'Wedding services section 3 created successfully';
            }

            $responseData = $section->toArray();
            foreach (['card1_image', 'card2_image'] as $imageField) {
                if (isset($responseData[$imageField]) && $responseData[$imageField] && !filter_var($responseData[$imageField], FILTER_VALIDATE_URL)) {
                    $responseData[$imageField] = asset('storage/' . ltrim($responseData[$imageField], '/'));
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            Log::error('Error in store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $section = WeddingServicesSection3::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding services section 3 not found'
                ], 404);
            }

            // Update basic fields
            if ($request->has('title')) $section->title = $request->title;
            if ($request->has('card1_title')) $section->card1_title = $request->card1_title;
            if ($request->has('card1_subtitle')) $section->card1_subtitle = $request->card1_subtitle;
            if ($request->has('card1_description')) $section->card1_description = $request->card1_description;
            if ($request->has('card2_title')) $section->card2_title = $request->card2_title;
            if ($request->has('card2_subtitle')) $section->card2_subtitle = $request->card2_subtitle;
            if ($request->has('card2_description')) $section->card2_description = $request->card2_description;
            
            // Handle Card 1 Image - Store ONLY RELATIVE PATH
            if ($request->hasFile('card1_image')) {
                // Delete old image if exists (only if it's a relative path)
                if ($section->card1_image && !filter_var($section->card1_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->card1_image);
                }
                $section->card1_image = $request->file('card1_image')->store('wedding-services-section3', 'public');
            } elseif ($request->has('card1_image_url') && $request->card1_image_url) {
                // Extract relative path from full URL if needed
                $url = $request->card1_image_url;
                if (str_contains($url, '/storage/')) {
                    $path = substr($url, strpos($url, '/storage/') + 9);
                    $section->card1_image = $path;
                } else {
                    $section->card1_image = $url;
                }
            }
            // If neither file nor URL is provided, card1_image REMAINS UNCHANGED
            
            // Handle Card 2 Image - Store ONLY RELATIVE PATH
            if ($request->hasFile('card2_image')) {
                // Delete old image if exists (only if it's a relative path)
                if ($section->card2_image && !filter_var($section->card2_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->card2_image);
                }
                $section->card2_image = $request->file('card2_image')->store('wedding-services-section3', 'public');
            } elseif ($request->has('card2_image_url') && $request->card2_image_url) {
                // Extract relative path from full URL if needed
                $url = $request->card2_image_url;
                if (str_contains($url, '/storage/')) {
                    $path = substr($url, strpos($url, '/storage/') + 9);
                    $section->card2_image = $path;
                } else {
                    $section->card2_image = $url;
                }
            }
            // If neither file nor URL is provided, card2_image REMAINS UNCHANGED
            
            $section->save();

            $responseData = $section->toArray();
            foreach (['card1_image', 'card2_image'] as $imageField) {
                if (isset($responseData[$imageField]) && $responseData[$imageField] && !filter_var($responseData[$imageField], FILTER_VALIDATE_URL)) {
                    $responseData[$imageField] = asset('storage/' . ltrim($responseData[$imageField], '/'));
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Wedding services section 3 updated successfully',
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            Log::error('Error in update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $section = WeddingServicesSection3::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding services section 3 not found'
                ], 404);
            }

            foreach (['card1_image', 'card2_image'] as $imageField) {
                if ($section->$imageField && !filter_var($section->$imageField, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($section->$imageField);
                }
            }

            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wedding services section 3 deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}