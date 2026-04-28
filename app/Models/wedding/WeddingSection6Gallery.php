<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection6Gallery extends Model
{
    protected $table = 'wedding_section6_gallery';
    
    protected $fillable = [
        'images'
    ];
    
    protected $casts = [
        'images' => 'array'
    ];
    
    // Accessor to get full image URLs
    public function getImagesAttribute($value)
    {
        $images = json_decode($value, true) ?: [];
        
        return array_map(function ($image) {
            // If it's already a full URL, return as is
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            // Otherwise, return the storage URL
            return asset('storage/' . $image);
        }, $images);
    }
    
    // Mutator to store image paths
    public function setImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } else {
            $this->attributes['images'] = $value;
        }
    }
}