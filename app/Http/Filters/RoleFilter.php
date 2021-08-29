<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class RoleFilter extends QueryFilter
{

    /**
     * Get filter callbacks
     *
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'search' => [$this, 'search'],
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
}
