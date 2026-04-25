<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeSectionOneController extends Controller
{
    /**
     * Public: Get Home Section One content.
     */
    public function index()
    {
        $section = HomeSectionOne::latest()->first();

        return response()->json([
            'success' => true,
            'data' => $section,
        ], 200);
    }

    /**
     * Public/Admin: Get one section by ID.
     */
    public function show($id)
    {
        $section = HomeSectionOne::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Home Section One not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $section,
        ], 200);
    }

    /**
     * Admin: Create Home Section One.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'is_active' => ['nullable', 'boolean'],
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
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : true,
        ];

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('home-section-one', 'public');
        }

        $section = HomeSectionOne::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Home Section One created successfully.',
            'data' => $section,
        ], 201);
    }

    /**
     * Admin: Update Home Section One.
     */
    public function update(Request $request, $id)
    {
        $section = HomeSectionOne::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Home Section One not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
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

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            $data['image_url'] = $request->file('image')->store('home-section-one', 'public');
        }

        $section->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Home Section One updated successfully.',
            'data' => $section->fresh(),
        ], 200);
    }

    /**
     * Admin: Delete Home Section One.
     */
    public function destroy($id)
    {
        $section = HomeSectionOne::find($id);

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Home Section One not found.',
            ], 404);
        }

        if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Home Section One deleted successfully.',
        ], 200);
    }
}