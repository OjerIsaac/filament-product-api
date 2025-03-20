<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that should be guarded.
     *
     * @var array<string, string>
     */
    protected $guarded = ['id'];
}
