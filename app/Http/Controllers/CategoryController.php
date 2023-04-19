<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryWithChildrenResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function getAll(): AnonymousResourceCollection
    {
        $headCategories = Category::query()
            ->whereNull('parent_id')
            ->with(['children', 'products'])
            ->orderBy('index', 'ASC')
            ->get();

        return CategoryWithChildrenResource::collection($headCategories);
    }
}
