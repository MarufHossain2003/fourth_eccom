<?php

namespace App\Models;

use App\Traits\HasSeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasSeoTrait;

    protected $guarded = [];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'cat_id', 'id');
    }
}

// Category has many subCategories
// Category has many products
