<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Services\Controllers\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ProductService::class);
    }

    /** @test */
    public function it_can_fetch_all_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/product');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'data' => [
                             '*' => ['id', 'name', 'category', 'status']
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $data = [
            'name' => 'Test Product',
            'category' => 'Electronics',
            'status' => true,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson(['message' => 'Product added Successfully']);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_can_fetch_a_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/product/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'data' => ['id', 'name', 'category', 'status']
                     ]
                 ]);
    }

    /** @test */
    public function it_returns_404_if_product_not_found()
    {
        $response = $this->getJson('/api/product/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'No query results for model [App\\Models\\Product].']);
    }
}

