<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasSlug;

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    public function children(): HasMany {
        return $this
            ->hasMany(Category::class, 'parent_id', 'id')
            ->orderBy('index', 'ASC')
            ->with('products', 'children')
            ;
    }
}