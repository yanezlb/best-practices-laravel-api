<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(){
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        $recipes = Recipe::factory(2)->create();

        $response = $this->getJson('/api/recipes');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['title', 'description'], // resto de campos
                    ]
                ]
            ]);
    }

    public function test_show(): void
    {
        $response = $this->get('/');
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        $recipe = Recipe::factory()->create();

        $response = $this->getJson('/api/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_OK) // 200
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'attributes' => ['title', 'description'], // resto de campos
                ]
            ]);
    }

    public function test_destroy(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        $recipe = Recipe::factory()->create();

        $response = $this->deleteJson('/api/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
