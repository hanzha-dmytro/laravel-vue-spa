<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    const IS_ACTIVE = 'active';
    const IS_VISIBLE = 'visible';

    private array $queryParams;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->queryParams = array_filter($request->query());
    }

    /**
     * Get filter callbacks
     *
     * @return array
     */
    abstract protected function getCallbacks(): array;

    /**
     * Call filter callbacks
     *
     * @param Builder $builder
     * @return Builder
     */
    final public function apply(Builder $builder): Builder
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if(isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }
        return $builder;
    }
}
