<?php

use App\Http\Controllers\ProductController;

use App\Http\Controllers\AuthController;


/* use Symfony\Component\Routing\Route; */

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(
function(){


Route::post('/products',[ProductController::class,'store']);

Route::get('/',[ProductController::class,'index']);

Route::delete('/products/{product}',[ProductController::class,'destroy']);

Route::put('/products/{product}',[ProductController::class,'update']);



}
);




Route::post('/signup',[AuthController::class,'register']);

Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->post('/logout',[AuthController::class,'logout']);






