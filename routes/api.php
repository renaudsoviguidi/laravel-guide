<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/category',CategoryController::class);
Route::apiResource('/products',ProductController::class);
Route::apiResource('/etablissements',EtablissementController::class);


