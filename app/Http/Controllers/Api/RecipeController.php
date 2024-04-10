<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        // all, get
        $recipes = Recipe::with('category','tags','user')->get();

        return RecipeResource::collection( $recipes );
    }

    public function store(Recipe $recipe) {   }

    public function show(Recipe $recipe)
    {
        $recipe = $recipe->load('category','tags','user');

        return new RecipeResource($recipe);
    }

    public function udpate(Recipe $recipe) {   }

    public function destroy(Recipe $recipe) {   }

}
