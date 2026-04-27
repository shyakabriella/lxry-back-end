<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section10Sauna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Section10SaunaController extends Controller
{
    /**
     * Public: Get all active sauna images/content.
     */
    public function getSection()
    {
        $sections = Section10Sauna::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        if ($sections->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Sauna section content not found',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $sections,
        ], 200);
    }

    /**
     * Admin: Create one or many sauna images.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Multiple upload support
        |--------------------------------------------------------------------------
        | Frontend can send:
        | images[]
        | titles[]
        | subtitles[]
        | descriptions[]
        | sort_orders[]
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('images')) {
            $validator = Validator::make($request->all(), [
                'images' => ['required', 'array', 'min:1'],
                'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],

                'titles' => ['nullable', 'array'],
                'titles.*' => ['nullable', 'string', 'max:255'],

                'subtitles' => ['nullable', 'array'],
                'subtitles.*' => ['nullable', 'string', 'max:255'],

                'descriptions' => ['nullable', 'array'],
                'descriptions.*' => ['nullable', 'string'],

                'sort_orders' => ['nullable', 'array'],
                'sort_orders.*' => ['nullable', 'integer'],

                'is_active' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $created = [];

            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('section-10-sauna', 'public');

                $created[] = Section10Sauna::create([
                    'title' => $request->input("titles.$index", 'Sauna & Massage Experience'),
                    'subtitle' => $request->input("subtitles.$index", 'Relax. Restore. Rebalance.'),
                    'description' => $request->input("descriptions.$index", ''),
                    'image_url' => $imagePath,
                    'sort_order' => $request->input("sort_orders.$index", $index + 1),
                    'is_active' => $request->has('is_active')
                        ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                        : true,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sauna images created successfully.',
                'data' => $created,
            ], 201);
        }

        /*
        |--------------------------------------------------------------------------
        | Single upload support
        |--------------------------------------------------------------------------
        */
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $imagePath = $request->file('image')->store('section-10-sauna', 'public');

        $section = Section10Sauna::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image_url' => $imagePath,
            'sort_order' => $request->filled('sort_order') ? $request->sort_order : 0,
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sauna image created successfully.',
            'data' => $section,
        ], 201);
    }

    /**
     * Admin: Update one sauna image/content.
     */
    public function update(Request $request, $id)
    {
        $section = Section10Sauna::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Sauna section not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'subtitle' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
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

        if ($request->has('sort_order')) {
            $data['sort_order'] = $request->sort_order;
        }

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            $data['image_url'] = $request->file('image')->store('section-10-sauna', 'public');
        }

        $section->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sauna section updated successfully',
            'data' => $section->fresh(),
        ], 200);
    }

    /**
     * Keep this method because your route currently uses updateImages.
     */
    public function updateImages(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    /**
     * Admin: Delete one sauna image/content.
     */
    public function destroy($id)
    {
        $section = Section10Sauna::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Sauna section not found',
            ], 404);
        }

        if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sauna section deleted successfully',
        ], 200);
    }
}