<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantBooking extends Model
{
    protected $fillable = [
        'booking_code',
        'customer_name',
        'phone',
        'email',
        'booking_type',
        'payment_method',
        'booking_date',
        'booking_time',
        'party_size',
        'custom_dish',
        'notes',
        'subtotal',
        'total',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'booking_date' => 'date:Y-m-d',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'party_size' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(RestaurantBookingItem::class);
    }
}