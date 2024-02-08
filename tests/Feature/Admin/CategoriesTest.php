<?php

namespace Tests\Feature\Admin;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
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

    public function test_use_categories_role_with_admin()
    {
        $categories = Category::factory(2)->create();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))->get(route('admin.categories.index'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.categories.index');

//        $response->assertSee($categories->pluck('id')->toArray());
    }


    public function test_dont_use_categories_role_with_customer()
    {
        $response = $this->actingAs($this->getUser(Roles::CUSTOMER))
            ->get(route('admin.categories.index'));

        $response->assertStatus(403);
    }

    public function test_create_category_with_valid_data()
    {
        $data = Category::factory()->make()->toArray();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->post(route('admin.categories.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.categories.index');
        $this->assertDatabaseHas(Category::class, [
            'name' => $data['name']
        ]);
    }

    public function test_create_category_with_invalid_data()
    {
        $data = ['name' => 'q'];

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->post(route('admin.categories.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing(Category::class, [
            'name' => $data['name']
        ]);
    }

    public function test_update_category_with_valid_data()
    {
        $category = Category::factory()->create();
        $parent = Category::factory()->create();

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->put(route('admin.categories.update', $category), [
                'name' => $category->name,
                'parent_id' => $parent->id
            ]);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.categories.edit', compact('category'));

        $category->refresh();

        $this->assertEquals($category->parent_id, $parent->id);
    }

    public function test_update_category_with_invalid_data()
    {
        $category = Category::factory()->create();
        $parent = 10000;

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->put(route('admin.categories.update', $category), [
                'name' => '',
                'parent_id' => $parent,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'parent_id']);
        $category->refresh();
        $this->assertNotEquals($category->parent_id, $parent);
    }

    public function test_remove_categories()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);

        $response = $this->actingAs($this->getUser(Roles::ADMIN))
            ->delete(route('admin.categories.destroy', $category));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.categories.index');

        $this->assertDatabaseMissing(Category::class, [
            'id' => $category->id
        ]);
    }
    public function test_remove_failed_categories()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);

        $userWithoutPermission = User::factory()->create();

        $response = $this->actingAs($userWithoutPermission)
            ->delete(route('admin.categories.destroy', ['category' => $category]));

        $response->assertStatus(403);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id
        ]);
    }

    protected function getUser(Roles $role): User
    {
        return User::role($role->value)->firstOrFail();
    }

}
