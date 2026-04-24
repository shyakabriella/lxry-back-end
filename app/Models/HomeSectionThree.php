<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSectionThree extends Model
{
    protected $fillable = [
        'title_one',
        'title_two',
        'description',
        'image',
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