<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WelcomeSlideController extends Controller
{
    /**
     * Get all welcome slides for React frontend.
     */
    public function index()
    {
        $slides = WelcomeSlide::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $slides,
        ], 200);
    }

    /**
     * Get single welcome slide.
     */
    public function show($id)
    {
        $slide = WelcomeSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $slide,
        ], 200);
    }

    /**
     * Create new welcome slide.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
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

        $imagePath = $request->file('image')->store('welcome-slides', 'public');

        $slide = WelcomeSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image_url' => $imagePath,
            'sort_order' => $request->filled('sort_order') ? $request->sort_order : 0,
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully.',
            'data' => $slide,
        ], 201);
    }

    /**
     * Update welcome slide.
     */
    public function update(Request $request, $id)
    {
        $slide = WelcomeSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
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

        if ($request->has('button_text')) {
            $data['button_text'] = $request->button_text;
        }

        if ($request->has('button_link')) {
            $data['button_link'] = $request->button_link;
        }

        if ($request->has('sort_order')) {
            $data['sort_order'] = $request->sort_order;
        }

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->hasFile('image')) {
            if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
                Storage::disk('public')->delete($slide->image_url);
            }

            $data['image_url'] = $request->file('image')->store('welcome-slides', 'public');
        }

        $slide->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully.',
            'data' => $slide->fresh(),
        ], 200);
    }

    /**
     * Delete welcome slide.
     */
    public function destroy($id)
    {
        $slide = WelcomeSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found.',
            ], 404);
        }

        if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
            Storage::disk('public')->delete($slide->image_url);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully.',
        ], 200);
    }
}