<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSectionFour extends Model
{
    protected $fillable = [
        'eyebrow',
        'title_line_one',
        'title_line_two',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
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