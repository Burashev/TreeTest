<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryWithChildrenResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

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

    public function update(Category $category, Request $request): CategoryWithChildrenResource
    {
        $request->validate([
            'parent_id' => 'required|exists:categories,id',
            'index' => "required"
        ]);

        $parentId = request('parent_id');
        $index = request('index');

        // транзакция для атомарности
        DB::beginTransaction();

        // сортировка будет разная в двух случаях
        // 1 - когда мы меняем на другого родителя
        // 2 - когда родитель остается, но индекс меняется
        if ($category->parent_id !== $parentId) {

            // увеличиваем индекс на +1 у тех категорий у которых index >= вставляемому индексу
            DB::table('categories')
                ->where('parent_id', $parentId)
                ->where('index', '>=', $index)
                ->update([
                    'index' => DB::raw('index + 1')
                ]);

            // уменьшаем индексы на -1 у изначальной родительской категории
            DB::table('categories')
                ->where('parent_id', $category->parent_id)
                ->where('index', '>', $category->index)
                ->update([
                    'index' => DB::raw('index - 1')
                ]);
        } else {
            // в случае если мы двигаем индекс внутри изначальной родительской категории, есть 2 варианта
            // когда изначальный индекс категории меньше заменяемого индекса
            if ($category->index < $index) {
                DB::table('categories')
                    ->where('parent_id', $parentId)
                    ->whereBetween('index', [$category->index + 1, $index])
                    ->update([
                        'index' => DB::raw('index - 1')
                    ]);
            }
            // когда изначальный индекс категории больше заменяемого индекса
            else if ($category->index > $index) {
                DB::table('categories')
                    ->where('parent_id', $parentId)
                    ->where('index', '>=', $index)
                    ->update([
                        'index' => DB::raw('index + 1')
                    ]);
            }
        }

        $category->update([
            'parent_id' => $parentId,
            'index' => $index
        ]);

        DB::commit();

        return CategoryWithChildrenResource::make($category);
    }
}
