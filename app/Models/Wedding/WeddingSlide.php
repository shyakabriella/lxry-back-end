<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSlide extends Model
{
    protected $table = 'wedding_slides';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url',
        'sort_order'
    ];
    
    // Accessor to get full image URL
    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }
        // If it's already a full URL, return it
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Otherwise, return the storage URL
        return asset('storage/' . $value);
    }
}   