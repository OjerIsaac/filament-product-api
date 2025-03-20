<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Product;
use Illuminate\Http\Response;
use Filament\Pages\Actions\DeleteAction;
use App\Services\Controllers\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $service;
    protected $admin;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ProductService::class);

        // Create an admin user
        $this->admin = User::factory()->create([
            'email' => 'user.admin@filamentproduct.com',
            'password' => bcrypt('123456'),
        ]);

        // Create a sample product
        $this->product = Product::factory()->create([
            'name' => 'Test Product',
            'category' => 'Electronics',
            'status' => true,
        ]);
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

    // ================= FILAMENT ADMIN DASHBOARD TESTS ==================

    /** @test */
    public function admin_can_update_a_product()
    {
        $product = Product::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(EditProduct::class, ['record' => $product->id])
            ->set('data.name', 'Updated Product')
            ->set('data.category', 'Updated Category')
            ->set('data.status', false)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'category' => 'Updated Category',
            'status' => false,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_product()
    {
        $product = Product::factory()->create();
        $this->actingAs($this->admin);

        Livewire::test(ListProducts::class)
            ->callTableAction('delete', $product); 

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
