<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MassageSpaPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'intro_eyebrow',
        'intro_title',
        'intro_description',
        'experience_title',
        'experience_description',
        'experience_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'hero_image_url',
        'experience_image_url',
    ];

    public function getHeroImageUrlAttribute(): ?string
    {
        if (!$this->hero_image) {
            return null;
        }

        return url(Storage::url($this->hero_image));
    }

    public function getExperienceImageUrlAttribute(): ?string
    {
        if (!$this->experience_image) {
            return null;
        }

        return url(Storage::url($this->experience_image));
    }
}