<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_without_read_permission_cannot_view_products()
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/products')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_read_permission_can_view_and_search_products()
    {
        $user = $this->createUser('admin', ['read_products']);
        $this->actingAs($user)->get('dashboard/products')->assertStatus(200);

        $product = factory('App\Product')->create();
        $this->actingAs($user)->get('dashboard/products?search=' .$product->name)
            ->assertSee($product->name);

        $this->actingAs($user)->get('dashboard/products?category_id=' .$product->category->id)
            ->assertSee($product->name);
    }

    /** @test */
    public function there_is_no_route_for_viewing_a_product()
    {
        $user = $this->createUser('admin', ['read_products']);

        $product = factory('App\Product')->create();
        
        $this->actingAs($user)->get('dashboard/products/{$product->id}')->assertStatus(404);
    }

    /** @test */
    public function creating_a_product_validation()
    {
        $user = $this->createUser('admin', ['create_products']);

        $product = [
            'category_id'=>'', 
            'name'=>'', 
            'description'=>'', 
            'purchase_price'=>'', 
            'sale_price'=>'', 
            'stock'=>''
        ];

        $this->actingAs($user)->post('dashboard/products', $product)
            ->assertSessionHasErrors('category_id')
            ->assertSessionHasErrors('ar.name')
            ->assertSessionHasErrors('en.name')
            ->assertSessionHasErrors('ar.description')
            ->assertSessionHasErrors('en.description')
            ->assertSessionHasErrors('purchase_price')
            ->assertSessionHasErrors('sale_price')
            ->assertSessionHasErrors('stock');
    }

    /** @test */
    public function a_user_without_create_permission_cannot_create_products()
    {
        $user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/products/create')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_create_permission_can_create_products()
    {
        $user = $this->createUser('admin', ['create_products']);

        $this->actingAs($user)->get('dashboard/products/create')->assertStatus(200);  

        $category = factory('App\Category')->create();

        $product = [
            'category_id' => $category->id,
            'ar' => ['name' => 'name ar', 'description' => 'desc ar'], 
            'en' => ['name' => 'name en', 'description' => 'desc en'],
            'purchase_price' => 100,
            'sale_price' => 100,
            'stock' => 100
        ];

        $this->actingAs($user)->post('dashboard/products', $product);

        $this->assertDatabaseHas('products', ['category_id' => $category->id]);
        $this->assertDatabaseHas('product_translations', ['name' => 'name ar', 'description' => 'desc ar']);
        $this->assertDatabaseHas('product_translations', ['name' => 'name en', 'description' => 'desc en']);
    }

    /** @test */
    public function a_user_without_update_permission_cannot_update_products()
    {
        $user = $this->createUser('admin');

        $product = factory('App\Product')->create();

        $this->actingAs($user)->get("dashboard/products/{$product->id}/edit")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_update_permission_can_update_products() 
    {
        $this->withoutExceptionHandling();
        $user = $this->createUser('admin', ['update_products']);

        $product = factory('App\Product')->create();
        
        $this->actingAs($user)->get("dashboard/products/{$product->id}/edit")->assertStatus(200);  

        $category = factory('App\Category')->create();
        
        $attributes = [
            'category_id' => $category->id,
            'ar' => ['name' => 'name ar', 'description' => 'desc ar'], 
            'en' => ['name' => 'name en', 'description' => 'desc en'],
            'purchase_price' => 100,
            'sale_price' => 100,
            'stock' => 100
        ];

        $this->actingAs($user)->put("dashboard/products/{$product->id}", $attributes);
        
        $this->assertDatabaseHas('products', ['category_id' => $category->id]);
        $this->assertDatabaseHas('product_translations', ['name' => 'name ar', 'description' => 'desc ar']);
        $this->assertDatabaseHas('product_translations', ['name' => 'name en', 'description' => 'desc en']);
    }

    /** @test */
    public function a_user_without_delete_permission_cannot_delete_products()
    {
        $user = $this->createUser('admin');

        $product = factory('App\Product')->create();

        $this->actingAs($user)->delete("dashboard/products/{$product->id}")->assertStatus(403);
    }

    /** @test */
    public function a_user_with_delete_permission_can_delete_products()
    {
        $user = $this->createUser('admin', ['delete_products']);

        $product = factory('App\Product')->create();

        $this->actingAs($user)->delete("dashboard/products/{$product->id}");

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
