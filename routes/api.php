<?php

use App\Http\Controllers\Common\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('product', ProductController::class);