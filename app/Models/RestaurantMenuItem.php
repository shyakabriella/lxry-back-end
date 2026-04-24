<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantMenuItem extends Model
{
    protected $fillable = [
        'tab',
        'category',
        'name',
        'description',
        'price',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }
}