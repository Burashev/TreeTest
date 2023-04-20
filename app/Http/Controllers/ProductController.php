<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function products(): AnonymousResourceCollection
    {
        $searchQuery = request()->query('search');
        $sortQuery = request()->query('sort', 'asc');

        $products = Product::query()
            ->when($searchQuery, fn(Builder $builder) => $builder->whereFullText(['title', 'description'], $searchQuery))
            ->orderBy('title', $sortQuery)
            ->get();

        return ProductResource::collection($products);
    }
}
