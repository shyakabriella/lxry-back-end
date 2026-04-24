<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MassageSpaBenefit;
use App\Models\MassageSpaItem;
use App\Models\MassageSpaPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MassageSpaController extends Controller
{
    /**
     * Public page data
     */
    public function index()
    {
        $page = MassageSpaPage::where('is_active', true)->latest()->first();

        $spaServices = MassageSpaItem::where('section', 'spa_service')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $wellnessEnhancements = MassageSpaItem::where('section', 'wellness_enhancement')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $benefits = MassageSpaBenefit::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa page fetched successfully.',
            'data' => [
                'page' => $page,
                'spa_services' => $spaServices,
                'wellness_enhancements' => $wellnessEnhancements,
                'spa_benefits' => $benefits,
            ],
        ], 200);
    }

    /**
     * Admin full data
     */
    public function adminData()
    {
        $page = MassageSpaPage::latest()->first();

        $items = MassageSpaItem::orderBy('section')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $benefits = MassageSpaBenefit::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa admin data fetched successfully.',
            'data' => [
                'page' => $page,
                'items' => $items,
                'benefits' => $benefits,
            ],
        ], 200);
    }

    /**
     * Create or update the main page singleton
     */
    public function savePage(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'intro_eyebrow' => ['nullable', 'string', 'max:255'],
            'intro_title' => ['nullable', 'string', 'max:255'],
            'intro_description' => ['nullable', 'string'],

            'experience_title' => ['nullable', 'string', 'max:255'],
            'experience_description' => ['nullable', 'string'],
            'experience_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'is_active' => ['nullable', 'boolean'],
        ]);

        $page = MassageSpaPage::first();

        if (!$page) {
            $page = new MassageSpaPage();
        }

        if ($request->hasFile('hero_image')) {
            if ($page->hero_image && Storage::disk('public')->exists($page->hero_image)) {
                Storage::disk('public')->delete($page->hero_image);
            }

            $validated['hero_image'] = $request->file('hero_image')->store('massage-spa', 'public');
        }

        if ($request->hasFile('experience_image')) {
            if ($page->experience_image && Storage::disk('public')->exists($page->experience_image)) {
                Storage::disk('public')->delete($page->experience_image);
            }

            $validated['experience_image'] = $request->file('experience_image')->store('massage-spa', 'public');
        }

        $page->fill($validated);
        $page->save();

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa page saved successfully.',
            'data' => $page->fresh(),
        ], 200);
    }

    /**
     * Store section item
     */
    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'section' => ['required', 'in:spa_service,wellness_enhancement'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('massage-spa-items', 'public');
        }

        $item = MassageSpaItem::create([
            'section' => $validated['section'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa item created successfully.',
            'data' => $item,
        ], 201);
    }

    /**
     * Update section item
     */
    public function updateItem(Request $request, string $id)
    {
        $item = MassageSpaItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Massage & Spa item not found.',
            ], 404);
        }

        $validated = $request->validate([
            'section' => ['sometimes', 'required', 'in:spa_service,wellness_enhancement'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('massage-spa-items', 'public');
        }

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa item updated successfully.',
            'data' => $item->fresh(),
        ], 200);
    }

    /**
     * Delete section item
     */
    public function destroyItem(string $id)
    {
        $item = MassageSpaItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Massage & Spa item not found.',
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa item deleted successfully.',
        ], 200);
    }

    /**
     * Store benefit
     */
    public function storeBenefit(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $benefit = MassageSpaBenefit::create([
            'title' => $validated['title'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa benefit created successfully.',
            'data' => $benefit,
        ], 201);
    }

    /**
     * Update benefit
     */
    public function updateBenefit(Request $request, string $id)
    {
        $benefit = MassageSpaBenefit::find($id);

        if (!$benefit) {
            return response()->json([
                'status' => false,
                'message' => 'Massage & Spa benefit not found.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $benefit->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa benefit updated successfully.',
            'data' => $benefit->fresh(),
        ], 200);
    }

    /**
     * Delete benefit
     */
    public function destroyBenefit(string $id)
    {
        $benefit = MassageSpaBenefit::find($id);

        if (!$benefit) {
            return response()->json([
                'status' => false,
                'message' => 'Massage & Spa benefit not found.',
            ], 404);
        }

        $benefit->delete();

        return response()->json([
            'status' => true,
            'message' => 'Massage & Spa benefit deleted successfully.',
        ], 200);
    }
}