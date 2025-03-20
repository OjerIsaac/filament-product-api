<?php

namespace App\Traits\Filter;

use Illuminate\Support\Str;

trait HasRequestFilter
{
    /**
     * Convert Class name to snake case equivalent
     *
     * @return string
     */
    public function filterName()
    {
        return Str::snake(class_basename($this));
    }
}