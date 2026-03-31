<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Category extends Model
{
    use HasCustomId;

    protected $fillable = ['name', 'image'];

    public function getTablePrefix()
    {
        return 'CAT';
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'category_id', 'subcategory_id');
    }
}
