<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSectionFive extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'description',
        'button_text',
        'button_link',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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