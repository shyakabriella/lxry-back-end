<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section7Fitness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Section7FitnessController extends Controller
{
    /**
     * Get fitness section content for frontend.
     */
    public function getSection()
    {
        $section = Section7Fitness::first();

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section content not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section,
        ], 200);
    }

    /**
     * Create or update fitness section.
     */
    public function store(Request $request)
    {
        $section = Section7Fitness::first();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => $section
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096'
                : 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($section && $section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            $data['image_url'] = $request->file('image')->store('section-7-fitness', 'public');
        }

        if ($section) {
            $section->update($data);
            $message = 'Fitness section updated successfully.';
        } else {
            $section = Section7Fitness::create($data);
            $message = 'Fitness section created successfully.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section->fresh(),
        ], 200);
    }

    /**
     * Update fitness section.
     */
    public function update(Request $request, $id)
    {
        $section = Section7Fitness::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [];

        if ($request->has('title')) {
            $data['title'] = $request->title;
        }

        if ($request->has('subtitle')) {
            $data['subtitle'] = $request->subtitle;
        }

        if ($request->has('description')) {
            $data['description'] = $request->description;
        }

        if ($request->hasFile('image')) {
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            $data['image_url'] = $request->file('image')->store('section-7-fitness', 'public');
        }

        $section->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Fitness section updated successfully.',
            'data' => $section->fresh(),
        ], 200);
    }

    /**
     * Delete fitness section.
     */
    public function destroy($id)
    {
        $section = Section7Fitness::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness section not found',
            ], 404);
        }

        if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fitness section deleted successfully',
        ], 200);
    }
}