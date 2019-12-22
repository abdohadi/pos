<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_without_read_permission_cannot_view_categories()
    {
        // $this->withoutExceptionHandling();t
        $user = $this->createUser('admin', ['create_categories']);

        $this->actingAs($user)->get('dashboard/categories')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_read_permission_can_view_and_search_categories()
    {
        $user = $this->createUser('admin', ['read_categories']);
        $this->actingAs($user)->get('dashboard/categories')->assertStatus(200);

        $category = factory('App\Category')->create();
        $this->actingAs($user)->get('dashboard/categories?search=' .$category->name)->assertSee($category->name);  
    }

    /** @test */
    public function there_is_no_route_for_viewing_a_category()
    {
        $user = $this->createUser('admin', ['read_categories']);

        $category = factory('App\Category')->create();
        
        $this->actingAs($user)->get('dashboard/categories/{$category->id}')->assertStatus(404);
    }

    /** @test */
    public function creating_a_category_requires_a_name()
    {
        $user = $this->createUser('admin', ['create_categories']);

        $category = factory('App\Category')->raw(['name'=>'']);

        $this->actingAs($user)->post('dashboard/categories', $category)
            ->assertSessionHasErrors('ar.name')
            ->assertSessionHasErrors('en.name');
    }

    /** @test */
    public function a_user_without_create_permission_cannot_create_categories()
    {
        $user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/categories/create')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_create_permission_can_create_categories() 
    {
        $user = $this->createUser('admin', ['create_categories']);

        $this->actingAs($user)->get('dashboard/categories/create')->assertStatus(200);  

        $attributes = ['ar' => ['name' => 'name ar'], 'en' => ['name' => 'name en']];

        $this->actingAs($user)->post('dashboard/categories', $attributes);
        
        $this->assertDatabaseHas('category_translations', ['name' => 'name ar']);
        $this->assertDatabaseHas('category_translations', ['name' => 'name en']);
    }

    /** @test */
    public function a_user_without_update_permission_cannot_update_categories()
    {
        $user = $this->createUser('admin');

        $category = factory('App\Category')->create();

        $this->actingAs($user)->get("dashboard/categories/{$category->id}/edit")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_update_permission_can_update_categories() 
    {
        $user = $this->createUser('admin', ['update_categories']);

        $category = factory('App\Category')->create();
        
        $this->actingAs($user)->get("dashboard/categories/{$category->id}/edit")->assertStatus(200);  

        $attributes = ['ar' => ['name' => 'name ar'], 'en' => ['name' => 'name en']];

        $this->put("dashboard/categories/{$category->id}", $attributes);
        
        $this->assertDatabaseHas('category_translations', ['name' => 'name ar']);
        $this->assertDatabaseHas('category_translations', ['name' => 'name en']);
    }

    /** @test */
    public function a_user_without_delete_permission_cannot_delete_categories()
    {
        $user = $this->createUser('admin');

        $category = factory('App\Category')->create();

        $this->actingAs($user)->delete("dashboard/categories/{$category->id}")->assertStatus(403);
    }

    /** @test */
    public function a_user_with_delete_permission_can_delete_categories()
    {
        $user = $this->createUser('admin', ['delete_categories']);

        $category = factory('App\Category')->create();

        $this->actingAs($user)->delete("dashboard/categories/{$category->id}");

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
