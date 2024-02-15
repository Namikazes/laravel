<?php

namespace Tests\Feature\Admin;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\FileStorageServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function afterRefreshingDatabase(): void
    {
        $this->seed();
    }

    public function test_create_product()
    {
        $file = UploadedFile::fake()->image('img_test.png');

        $productData = Product::factory()->make();

        $data = $productData->toArray();
        $data['thumbnail'] = $file;

        $this->mock(
            FileStorageServices::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('upload')
                    ->andReturn('image_uploaded.img');
            }
        );

          $this->actingAs($this->getUser(Roles::ADMIN))
            ->post(route('admin.products.store'), $data);

        $this->assertDatabaseHas(Product::class, [
            'title' => $productData->title,
            'slug' => $productData->slug,
            'SKU' => $productData->SKU,
            'price' => $productData->price,
            'description' => $productData->description,
            'new_price' => $productData->new_price,
            'quantity' => $productData->quantity,
            'thumbnail' => 'image_uploaded.img'
        ]);

        $product = Product::where('title', $productData->title)->first();

    }

    public function test_use_products_role_admin()
    {
        $data = Product::factory(1)->create();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->get(route('admin.products.index'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.products.index');
//        $response->assertSeeTextInOrder($data->pluck('id')->toArray());
    }

    public function test_dont_use_products_role_customer()
    {
        $response = $this->actingAs($this->getUser(Roles::CUSTOMER))
            ->get(route('admin.products.index'));

        $response->assertStatus(403);
    }

    public function test_create_product_with_invalid_data()
    {
        $data = ['title' => 'e'];

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->post(route('admin.products.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseMissing(Product::class, [
            'title' => $data['title']
        ]);
    }

    public function test_update_products_with_valid_data()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->put(route('admin.products.update', $product), [
                'title' => $product->title,
                'SKU' => $product->SKU,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ]);
        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.products.edit', compact('product'));
        $product->refresh();

        $this->assertEquals($product['title'], $product->title);
        $this->assertEquals($product['SKU'], $product->SKU);
        $this->assertEquals($product['price'], $product->price);
        $this->assertEquals($product['quantity'], $product->quantity);
    }

    public function test_update_products_with_invalid_data()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->put(route('admin.products.update', $product), [
                'title' => '',
                'SKU' => $product->SKU,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ]);

        $response->assertStatus(302);
        $product->refresh();
        $this->assertNotEquals('', $product->title);
        $this->assertEquals($product->SKU, $product->SKU);
        $this->assertEquals($product->price, $product->price);
        $this->assertEquals($product->quantity, $product->quantity);
    }

    public function test_remove_products()
    {
        $data = Product::factory()->create();

        $this->assertDatabaseHas(Product::class, [
            'id' => $data['id']
        ]);

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->delete(route('admin.products.destroy', $data));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.products.index');

        $this->assertDatabaseMissing(Product::class, [
            'id' => $data['id']
        ]);
    }

    public function test_remove_failed_products()
    {
        $product = Product::factory()->create();
        $nonExistentProductId = 9999;

        $this->assertDatabaseHas(Product::class, ['id' => $product->id]);

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->delete(route('admin.products.destroy', $product));

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->delete(route('admin.products.destroy', $nonExistentProductId));
        $response->assertStatus(404);

        $this->assertDatabaseMissing(Category::class, [
            'id' => $product->id
        ]);
    }

    protected function getUser(Roles $role): User
    {
        return User::role($role->value)->firstOrFail();
    }
}
