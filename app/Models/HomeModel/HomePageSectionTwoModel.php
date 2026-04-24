<?php

namespace App\Models\HomeModel;

use Illuminate\Database\Eloquent\Model;

class HomePageSectionTwoModel extends Model
{
    protected $table = 'home_page_section_two';

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image_url'
    ];
}