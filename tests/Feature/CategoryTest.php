<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testResource()
    {
        $this->seed([CategorySeeder::class]);

        $category = Category::first();

        $this->get("/api/categories/$category->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'created_at' => $category->created_at->toJSON(),
                    'updated_at' => $category->updated_at->toJSON(),
                ]
            ]);
    }

    public function testResourceCollection()
    {
        $this->seed([CategorySeeder::class]);

        $categories = Category::all();

        $this->get("/api/categories")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $categories[0]->id,
                        'name' => $categories[0]->name,
                    ],
                    [
                        'id' => $categories[1]->id,
                        'name' => $categories[1]->name,
                    ]
                ]
            ]);
    }

    public function testResourceCollectionCustome()
    {
        $this->seed([CategorySeeder::class]);

        $categories = Category::all();

        $this->get("/api/categories-custom")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $categories[0]->id,
                        'name' => $categories[0]->name,
                    ],
                    [
                        'id' => $categories[1]->id,
                        'name' => $categories[1]->name,
                    ]
                ],
                'total' => 2
            ]);
    }
}
