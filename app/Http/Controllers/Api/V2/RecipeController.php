<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RecipeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $recipes = Recipe::orderBy('id', 'DESC')
            ->with('category', 'tags', 'user')
            ->paginate();

        return RecipeResource::collection($recipes);
    }

}
