<?php

namespace App\Http\Controllers\API\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingSection1Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingSection1VenueController extends Controller
{
    public function getSection()
    {
        $section = WeddingSection1Venue::first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 content not found'
            ], 404);
        }

        // Process images - convert storage paths to full URLs
        $images = $section->images ?? [];
        $processedImages = [];
        foreach ($images as $image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                // Remove any duplicate storage prefix
                $cleanPath = preg_replace('/^\/?storage\//', '', $image);
                $processedImages[] = asset('storage/' . $cleanPath);
            } else {
                $processedImages[] = $image;
            }
        }

        $responseData = [
            'id' => $section->id,
            'title' => $section->title,
            'subtitle' => $section->subtitle,
            'description' => $section->description,
            'images' => $processedImages,
            'created_at' => $section->created_at,
            'updated_at' => $section->updated_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $responseData
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $images = [];

        // Handle image0 upload
        if ($request->hasFile('image0')) {
            $path0 = $request->file('image0')->store('wedding-envision', 'public');
            $images[0] = $path0;
        } elseif ($request->has('existing_image0') && $request->existing_image0) {
            // Extract path from URL or use as is
            $existingImage0 = $request->existing_image0;
            if (filter_var($existingImage0, FILTER_VALIDATE_URL)) {
                // If it's a full URL, extract the path after /storage/
                if (preg_match('/\/storage\/(.+)$/', $existingImage0, $matches)) {
                    $images[0] = $matches[1];
                } else {
                    $images[0] = $existingImage0;
                }
            } else {
                $images[0] = $existingImage0;
            }
        }

        // Handle image1 upload
        if ($request->hasFile('image1')) {
            $path1 = $request->file('image1')->store('wedding-envision', 'public');
            $images[1] = $path1;
        } elseif ($request->has('existing_image1') && $request->existing_image1) {
            $existingImage1 = $request->existing_image1;
            if (filter_var($existingImage1, FILTER_VALIDATE_URL)) {
                if (preg_match('/\/storage\/(.+)$/', $existingImage1, $matches)) {
                    $images[1] = $matches[1];
                } else {
                    $images[1] = $existingImage1;
                }
            } else {
                $images[1] = $existingImage1;
            }
        }

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle ?? '',
            'description' => $request->description ?? '',
            'images' => $images
        ];

        $section = WeddingSection1Venue::first();
        
        if ($section) {
            $section->update($data);
            $message = 'Wedding section 1 updated successfully';
        } else {
            $section = WeddingSection1Venue::create($data);
            $message = 'Wedding section 1 created successfully';
        }

        // Return with full image URLs
        $returnImages = [];
        foreach ($section->images as $image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                $cleanPath = preg_replace('/^\/?storage\//', '', $image);
                $returnImages[] = asset('storage/' . $cleanPath);
            } else {
                $returnImages[] = $image;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'id' => $section->id,
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'images' => $returnImages,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $section = WeddingSection1Venue::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->title ?? $section->title,
            'subtitle' => $request->subtitle ?? $section->subtitle,
            'description' => $request->description ?? $section->description,
        ];

        // Get existing images
        $images = $section->images ?? [];

        // Handle image0
        if ($request->hasFile('image0')) {
            // Delete old image if exists
            if (isset($images[0]) && $images[0] && Storage::disk('public')->exists($images[0])) {
                Storage::disk('public')->delete($images[0]);
            }
            $path0 = $request->file('image0')->store('wedding-envision', 'public');
            $images[0] = $path0;
        } elseif ($request->has('existing_image0')) {
            if ($request->existing_image0 === '') {
                // Remove image
                if (isset($images[0]) && $images[0] && Storage::disk('public')->exists($images[0])) {
                    Storage::disk('public')->delete($images[0]);
                }
                unset($images[0]);
            } else {
                $existingImage0 = $request->existing_image0;
                if (filter_var($existingImage0, FILTER_VALIDATE_URL)) {
                    if (preg_match('/\/storage\/(.+)$/', $existingImage0, $matches)) {
                        $images[0] = $matches[1];
                    } else {
                        $images[0] = $existingImage0;
                    }
                } else {
                    $images[0] = $existingImage0;
                }
            }
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            if (isset($images[1]) && $images[1] && Storage::disk('public')->exists($images[1])) {
                Storage::disk('public')->delete($images[1]);
            }
            $path1 = $request->file('image1')->store('wedding-envision', 'public');
            $images[1] = $path1;
        } elseif ($request->has('existing_image1')) {
            if ($request->existing_image1 === '') {
                if (isset($images[1]) && $images[1] && Storage::disk('public')->exists($images[1])) {
                    Storage::disk('public')->delete($images[1]);
                }
                unset($images[1]);
            } else {
                $existingImage1 = $request->existing_image1;
                if (filter_var($existingImage1, FILTER_VALIDATE_URL)) {
                    if (preg_match('/\/storage\/(.+)$/', $existingImage1, $matches)) {
                        $images[1] = $matches[1];
                    } else {
                        $images[1] = $existingImage1;
                    }
                } else {
                    $images[1] = $existingImage1;
                }
            }
        }

        // Reindex images array
        $data['images'] = array_values($images);
        
        $section->update($data);

        // Return with full image URLs
        $returnImages = [];
        foreach ($section->images as $image) {
            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                $cleanPath = preg_replace('/^\/?storage\//', '', $image);
                $returnImages[] = asset('storage/' . $cleanPath);
            } else {
                $returnImages[] = $image;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 1 updated successfully',
            'data' => [
                'id' => $section->id,
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'images' => $returnImages,
            ]
        ]);
    }

    public function destroy($id)
    {
        $section = WeddingSection1Venue::find($id);
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Wedding section 1 not found'
            ], 404);
        }

        // Delete all associated images
        $images = $section->images ?? [];
        foreach ($images as $image) {
            if ($image && Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wedding section 1 deleted successfully'
        ]);
    }
}