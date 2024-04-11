<?php

namespace App\Http\Controllers\Api\V1;

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
        // all, get
        $recipes = Recipe::with('category','tags','user')->get();

        return RecipeResource::collection( $recipes );
    }

    public function store(StoreRecipeRequest $request) {

        /* $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'image' => 'required|mimes:png',
        ]); */

        // $recipe = Recipe::create($request->all());
        $recipe = $request->user()->recipes()->create($request->all());
        $recipe->tags()->attach(json_decode($request->tags));

        $recipe->image = $request->file('image')->store('recipes', 'public');
        $recipe->save();

        return response()->json(new RecipeResource($recipe), Response::HTTP_CREATED); // 201
    }

    public function show(Recipe $recipe)
    {
        $recipe = $recipe->load('category','tags','user');

        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe) {

        $this->authorize('update', $recipe);

        $recipe->update($request->all());

        if($tags = json_decode($recipe->tags)){
            $tags = array_map( function ($item) { return $item->id; }, $tags );

            $recipe->tags()->sync($tags); // Agrega a lo que ya existe
        }

        if ($request->file('image')) {
            $recipe->image = $request->file('image')->store('recipes', 'public');
            $recipe->save();
        }

        return response()->json(new RecipeResource($recipe), Response::HTTP_OK); // 200
    }

    public function destroy(Request $request, Recipe $recipe) {

        $this->authorize('delete', $recipe);
        //echo $user->id;
        /* echo $recipe->user_id;
        die; */

        $recipe->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); // 204

    }

}
