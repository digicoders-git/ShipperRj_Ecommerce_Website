<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class SubCategory extends Model
{
    use HasCustomId;

    protected $fillable = ['category_id', 'name', 'image'];

    public function getTablePrefix()
    {
        return 'SUB';
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
}
