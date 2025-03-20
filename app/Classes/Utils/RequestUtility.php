<?php

namespace App\Classes\Utils;

use Illuminate\Http\Request;

class RequestUtility
{
    public $defaultLimit = 10;

    /**
     * Return the limit for paginating Eloquent Records
     *
     * @param integer|null $limit
     * @return int
     */
    public static function limit(Request $request): int
    {
        $limit =  (new self)->defaultLimit;
        if ($request->has('limit')) {
            $limit = (int)$request->get('limit');
        }

        return $limit;
    }
}
