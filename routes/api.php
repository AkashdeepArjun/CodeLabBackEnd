<?php

use App\Http\Controllers\ProductController;
/* use Symfony\Component\Routing\Route; */

use Illuminate\Support\Facades\Route;


Route::post('/products',[ProductController::class,'store']);

Route::get('/products',[ProductController::class,'index']);

Route::delete('/products/{product}',[ProductController::class,'destroy']);


