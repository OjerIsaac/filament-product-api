<?php

namespace App\Classes\QueryFilters;

use Closure;
use App\Traits\Filter\HasRequestFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class Filter
{
    use HasRequestFilter;

    /**
     * Handle an incoming request.
     *
     * @param  Builder  $request
     * @param  \Closure(Builder) $next
     * @return Builder
     */
    public function handle(Builder $builder, Closure $next)
    {
        if ( !request()->has($this->filterName()) ) {
            return $next($builder);
        }

        $builder = $next($builder);
        return $this->applyFilter($builder);
    }

    /**
     * Method to Apply Filter for Filter class
     *
     * @param Builder $builder
     * @return Builder
     */
    protected abstract function applyFilter(Builder $builder);
}
