<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WelcomeSlideController extends Controller  // Changed from WeddingSlideController to WelcomeSlideController
{
    // Get all welcome slides (public)
    public function index()
    {
        $slides = WelcomeSlide::orderBy('sort_order', 'asc')->get();
        
        $slides->transform(function ($slide) {
            if ($slide->image_url && !filter_var($slide->image_url, FILTER_VALIDATE_URL)) {
                $slide->image_url = asset('storage/' . $slide->image_url);
            }
            return $slide;
        });
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    // Get single slide (public)
    public function show($id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }
        
        if ($slide->image_url && !filter_var($slide->image_url, FILTER_VALIDATE_URL)) {
            $slide->image_url = asset('storage/' . $slide->image_url);
        }
        
        return response()->json([
            'success' => true,
            'data' => $slide
        ]);
    }

    // Create slide (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = $request->file('image')->store('welcome-slides', 'public');

        $slide = WelcomeSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_url' => $imagePath,
            'sort_order' => $request->sort_order ?? 0
            'success' => true,
            'data' => $slide
        ], 201);
    }

    // Update slide (admin)
    public function update(Request $request, $id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];

        if ($request->has('title')) {
            $data['title'] = $request->title;
        }

        if ($request->has('subtitle')) {
            $data['subtitle'] = $request->subtitle;
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
            'message' => 'Welcome slide updated successfully',
            'data' => $slide
        ]);
    }

    // Delete slide (admin)
    public function destroy($id)
    {
        $slide = WelcomeSlide::find($id);
        
        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        if ($slide->image_url && Storage::disk('public')->exists($slide->image_url)) {
            Storage::disk('public')->delete($slide->image_url);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Welcome slide deleted successfully'
        ]);
    }
}