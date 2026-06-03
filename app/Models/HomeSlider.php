<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class HomeSlider extends Model
{
    use HasCustomId;

    protected $table = 'home_sliders';

    protected $fillable = [
        'badge',
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_url',
        'image',
        'bg_color',
        'status',
        'sort_order',
    ];
}
