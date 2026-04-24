<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RestaurantBooking;
use App\Models\RestaurantMenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantBookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = RestaurantBooking::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('booking_type')) {
            $query->where('booking_type', $request->booking_type);
        }

        $bookings = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Restaurant bookings fetched successfully.',
            'data' => $bookings,
        ], 200);
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'booking_type' => ['required', 'in:table,buy_now'],
            'payment_method' => ['required', 'in:counter,room,card'],

            'booking_date' => ['nullable', 'date'],
            'booking_time' => ['nullable', 'date_format:H:i'],
            'party_size' => ['nullable', 'integer', 'min:1'],

            'custom_dish' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.restaurant_menu_item_id' => ['nullable', 'exists:restaurant_menu_items,id'],
            'items.*.item_name' => ['nullable', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $booking = DB::transaction(function () use ($validated) {
            $subtotal = 0;

            $booking = RestaurantBooking::create([
                'booking_code' => 'RBK-' . now()->format('YmdHis') . rand(100, 999),
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'booking_type' => $validated['booking_type'],
                'payment_method' => $validated['payment_method'],
                'booking_date' => $validated['booking_date'] ?? null,
                'booking_time' => $validated['booking_time'] ?? null,
                'party_size' => $validated['party_size'] ?? null,
                'custom_dish' => $validated['custom_dish'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'subtotal' => 0,
                'total' => 0,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            foreach ($validated['items'] as $item) {
                $menuItem = null;

                if (!empty($item['restaurant_menu_item_id'])) {
                    $menuItem = RestaurantMenuItem::find($item['restaurant_menu_item_id']);
                }

                $unitPrice = $menuItem ? (float) $menuItem->price : (float) ($item['unit_price'] ?? 0);
                $itemName = $menuItem ? $menuItem->name : ($item['item_name'] ?? 'Custom Item');
                $quantity = (int) $item['quantity'];
                $lineTotal = $unitPrice * $quantity;

                $booking->items()->create([
                    'restaurant_menu_item_id' => $menuItem?->id,
                    'item_name' => $itemName,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $lineTotal,
                ]);

                $subtotal += $lineTotal;
            }

            $booking->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            return $booking->load('items');
        });

        return response()->json([
            'status' => true,
            'message' => 'Restaurant booking created successfully.',
            'data' => $booking,
        ], 201);
    }

    /**
     * Display one booking.
     */
    public function show(string $id)
    {
        $booking = RestaurantBooking::with('items')->find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant booking not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Restaurant booking fetched successfully.',
            'data' => $booking,
        ], 200);
    }

    /**
     * Update booking main details/status.
     */
    public function update(Request $request, string $id)
    {
        $booking = RestaurantBooking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant booking not found.',
            ], 404);
        }

        $validated = $request->validate([
            'customer_name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'booking_type' => ['sometimes', 'required', 'in:table,buy_now'],
            'payment_method' => ['sometimes', 'required', 'in:counter,room,card'],

            'booking_date' => ['nullable', 'date'],
            'booking_time' => ['nullable', 'date_format:H:i'],
            'party_size' => ['nullable', 'integer', 'min:1'],

            'custom_dish' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'status' => ['nullable', 'in:pending,confirmed,completed,cancelled'],
            'payment_status' => ['nullable', 'in:unpaid,paid,failed'],
        ]);

        $booking->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Restaurant booking updated successfully.',
            'data' => $booking->fresh()->load('items'),
        ], 200);
    }

    /**
     * Delete booking.
     */
    public function destroy(string $id)
    {
        $booking = RestaurantBooking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant booking not found.',
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'status' => true,
            'message' => 'Restaurant booking deleted successfully.',
        ], 200);
    }
}