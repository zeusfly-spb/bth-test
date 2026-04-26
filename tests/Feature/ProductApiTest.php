<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(): array
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        return [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ];
    }

    public function test_products_index_is_public_and_returns_products(): void
    {
        $category = Category::factory()->create();
        Product::create([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 1000,
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'price', 'category_id'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_products_index_can_be_filtered_by_category_id(): void
    {
        $targetCategory = Category::factory()->create();
        $otherCategory = Category::factory()->create();

        Product::create([
            'name' => 'Included Product',
            'description' => 'Included',
            'price' => 1500,
            'category_id' => $targetCategory->id,
        ]);
        Product::create([
            'name' => 'Excluded Product',
            'description' => 'Excluded',
            'price' => 2500,
            'category_id' => $otherCategory->id,
        ]);

        $response = $this->getJson('/api/products?category_id='.$targetCategory->id);

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Included Product');
    }

    public function test_store_requires_authentication(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'New Product',
            'description' => 'Description',
            'price' => 3000,
            'category_id' => $category->id,
        ]);

        $response->assertUnauthorized();
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/products', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'price', 'category_id']);
    }

    public function test_authenticated_user_can_create_product(): void
    {
        $category = Category::factory()->create();

        $payload = [
            'name' => 'Created Product',
            'description' => 'Created description',
            'price' => 5000,
            'category_id' => $category->id,
        ];

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/products', $payload);

        $response->assertCreated()
            ->assertJsonPath('name', 'Created Product');

        $this->assertDatabaseHas('products', [
            'name' => 'Created Product',
            'category_id' => $category->id,
        ]);
    }

    public function test_authenticated_user_can_update_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::create([
            'name' => 'Old Name',
            'description' => 'Old Description',
            'price' => 2000,
            'category_id' => $category->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->putJson('/api/products/'.$product->id, [
                'name' => 'Updated Name',
                'price' => 3500,
            ]);

        $response->assertOk()
            ->assertJsonPath('name', 'Updated Name')
            ->assertJsonPath('price', 3500);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => 3500,
        ]);
    }

    public function test_authenticated_user_can_delete_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::create([
            'name' => 'Delete Product',
            'description' => 'Delete Description',
            'price' => 1200,
            'category_id' => $category->id,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/products/'.$product->id);

        $response->assertOk()
            ->assertJsonPath('result', true);

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }
}
