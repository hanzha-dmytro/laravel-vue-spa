<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends QueryFilter
{

    /**
     * Get filter callbacks
     *
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'search'      => [$this, 'search'],
            'visibility'  => [$this, 'visibility'],
            'category_id' => [$this, 'categoryId'],
        ];
    }

    /**
     * Filter by name, description or content
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function search(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', "%{$value}%")
            ->orWhere('description','like', "%{$value}%")
            ->orWhere('content','like', "%{$value}%");
    }

    /**
     *  Filter by visibility
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function visibility(Builder $builder, string $value): Builder
    {
        return $builder->where('is_visible', $value === self::IS_VISIBLE);
    }

    /**
     *  Filter by category_id
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function categoryId(Builder $builder, string $value): Builder
    {
        return $builder->where('category_id', $value);
    }
}
