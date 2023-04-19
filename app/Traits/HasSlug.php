<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
trait HasSlug
{
    public static function slugColumn(): string
    {
        return 'slug';
    }

    public static function slugFromColumn(): string
    {
        return 'title';
    }

    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->{static::slugColumn()} = self::generateSlug($model);
        });
    }

    protected static function generateSlug(Model $model): string {
        $originalSlug = Str::slug($model->{self::slugFromColumn()});
        $slug = $originalSlug;
        $iteration = 2;

        while (self::checkSlugUnique($model, $slug)) {
            $slug = \str($originalSlug)->append("_{$iteration}")->value();
            $iteration += 1;
        }

        return $slug;
    }

    protected static function checkSlugUnique(Model $model, string $slug): bool {
        return $model->newQuery()->where(static::slugColumn(), '=', $slug)->exists();
    }
}
