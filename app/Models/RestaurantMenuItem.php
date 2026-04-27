<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tab',
        'category_id',
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

    public function categoryRelation()
    {
        return $this->belongsTo(RestaurantMenuCategory::class, 'category_id');
    }
}