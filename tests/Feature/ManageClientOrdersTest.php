<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageClientOrdersTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function creating_an_order_validation()
    {
        $user = $this->createUser('admin', ['create_orders']);
        $client = factory('App\Client')->create();

        $this->actingAs($user)->post("dashboard/clients/{$client->id}/orders", ['products' => []])
            ->assertSessionHasErrors('products');
    }

    /** @test */
    public function a_user_without_create_permission_cannot_create_orders()
    {
        $user = $this->createUser('admin');
        $client = factory('App\Client')->create();

        $this->actingAs($user)->get("dashboard/clients/{$client->id}/orders/create")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_create_permission_can_create_orders() 
    {
        $user = $this->createUser('admin', ['create_orders']);
        $client = factory('App\Client')->create();
        $product = factory('App\Product')->create();

        $this->actingAs($user)->get("dashboard/clients/{$client->id}/orders/create")->assertStatus(200);  

        $attributes = ['products' => [$product->id => ['quantity' => 2]]];

        $this->actingAs($user)->post("dashboard/clients/{$client->id}/orders", $attributes);
        
        $this->assertDatabaseHas('orders', ['client_id' => $client->id]);
        $this->assertDatabaseHas('product_order', ['product_id' => $product->id]);
    }

    /** @test */
    public function a_user_without_update_permission_cannot_update_orders()
    {
        $user = $this->createUser('admin');
        $order = factory('App\Order')->create();
        $client = factory('App\Client')->create();

        $this->actingAs($user)->get("dashboard/clients/{$client->id}/orders/{$order->id}/edit")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_update_permission_can_update_orders() 
    {
        $user = $this->createUser('admin', ['update_orders']);
        $order = factory('App\Order')->create();
        $product = factory('App\Product')->create();

        $this->actingAs($user)->get("dashboard/clients/{$order->client->id}/orders/{$order->id}/edit")->assertStatus(200);

        $attributes = ['products' => [$product->id => ['quantity' => 2]]];

        $this->actingAs($user)->put("dashboard/clients/{$order->client->id}/orders/{$order->id}", $attributes);
        
        $this->assertDatabaseHas('product_order', ['quantity' => 2]);
    }
}
