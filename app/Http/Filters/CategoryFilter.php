<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends QueryFilter
{

    /**
     * Get filter callbacks
     *
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'search'     => [$this, 'search'],
            'visibility' => [$this, 'visibility'],
        ];
    }

    /**
     * Filter by name
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function search(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', "%{$value}%");
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
}
