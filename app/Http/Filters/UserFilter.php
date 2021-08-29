<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{

    /**
     * Get filter callbacks
     *
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            'search'  => [$this, 'search'],
            'status'  => [$this, 'status'],
            'role_id' => [$this, 'roleId'],
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
     *  Filter by category_id
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function roleId(Builder $builder, string $value): Builder
    {
        return $builder->where('role_id', $value);
    }

    /**
     *  Filter by status
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function status(Builder $builder, string $value): Builder
    {
        return $builder->where('is_active', $value === self::IS_ACTIVE);
    }
}
