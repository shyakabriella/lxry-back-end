<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section11Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Section11PoolController extends Controller
{
    public function getSection()
    {
        $section = Section11Pool::first();

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section content not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section,
        ], 200);
    }

    public function store(Request $request)
    {
        $section = Section11Pool::first();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => $section
                ? ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200']
                : ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
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

            $data['image_url'] = $request->file('image')->store('section-11-pool', 'public');
        }

        if ($section) {
            $section->update($data);
            $message = 'Pool section updated successfully';
        } else {
            $section = Section11Pool::create($data);
            $message = 'Pool section created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $section->fresh(),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $section = Section11Pool::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'subtitle' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
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

            $data['image_url'] = $request->file('image')->store('section-11-pool', 'public');
        }

        $section->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Pool section updated successfully',
            'data' => $section->fresh(),
        ], 200);
    }

    public function destroy($id)
    {
        $section = Section11Pool::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Pool section not found',
            ], 404);
        }

        if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pool section deleted successfully',
        ], 200);
    }
}