<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['parent_id', 'index'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->with(['category']);
    }

    public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(Category::class, 'parent_id', 'id')
            ->with(['children']);
    }

    public function children(): HasMany
    {
        return $this
            ->hasMany(Category::class, 'parent_id', 'id')
            ->orderBy('index', 'ASC')
            ->with(['products', 'children']);
    }
}
