<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TagController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::get('categories',            [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('recipes',            [RecipeController::class, 'index']);
Route::get('recipes/{recipe}', [RecipeController::class, 'show']);

Route::get('tags',            [TagController::class, 'index']);
Route::get('tags/{tag}',        [TagController::class, 'show']);
