<?php

namespace App\Http\Controllers\API\Wedding\Packages;

use App\Http\Controllers\Controller;
use App\Models\Wedding\Packages\WeddingPackagesSection4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WeddingPackagesSection4Controller extends Controller
{
    public function getSection()
    {
        try {
            $section = WeddingPackagesSection4::first();
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 4 not found'
                ], 404);
            }

            // Get items from JSON field or build from benefit fields
            $items = [];
            
            // First try to get from items JSON column
            if ($section->items && is_array($section->items)) {
                $items = $section->items;
            } else {
                // Fallback: collect from benefit fields
                for ($i = 1; $i <= 15; $i++) {
                    $benefitKey = "benefit{$i}";
                    if (!empty($section->$benefitKey)) {
                        $items[] = $section->$benefitKey;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $section->id,
                    'items' => $items
                ]
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
                'items' => 'nullable|array',
                'items.*' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $items = $request->items ?? [];
            
            // Filter out empty items
            $items = array_values(array_filter($items, function($item) {
                return !empty(trim($item));
            }));
            
            // Prepare data
            $data = ['items' => $items];
            
            // Also populate benefit fields for backward compatibility
            for ($i = 0; $i < 15; $i++) {
                $benefitKey = "benefit" . ($i + 1);
                $data[$benefitKey] = $items[$i] ?? null;
            }
            
            $section = WeddingPackagesSection4::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Wedding packages section 4 created successfully',
                'data' => [
                    'id' => $section->id,
                    'items' => $items
                ]
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
            $section = WeddingPackagesSection4::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 4 not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'items' => 'nullable|array',
                'items.*' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $items = $request->items ?? [];
            
            // Filter out empty items
            $items = array_values(array_filter($items, function($item) {
                return !empty(trim($item));
            }));
            
            // Update items JSON column
            $section->items = $items;
            
            // Also update benefit fields for backward compatibility
            for ($i = 0; $i < 15; $i++) {
                $benefitKey = "benefit" . ($i + 1);
                $section->$benefitKey = $items[$i] ?? null;
            }
            
            $section->save();

            return response()->json([
                'success' => true,
                'message' => 'Wedding packages section 4 updated successfully',
                'data' => [
                    'id' => $section->id,
                    'items' => $items
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in update: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $section = WeddingPackagesSection4::find($id);
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wedding packages section 4 not found'
                ], 404);
            }

            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wedding packages section 4 deleted successfully'
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