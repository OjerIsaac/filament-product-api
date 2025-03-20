<?php

namespace App\Classes\QueryFilters;

use App\Classes\QueryFilters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Sort extends Filter
{
    protected function applyFilter(Builder $builder)
    {
        return $builder->orderBy( 'id', request( $this->filterName() ) );
    }
}