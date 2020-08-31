<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageOrdersTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_without_read_permission_cannot_view_orders()
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUser('admin', ['create_orders']);

        $this->actingAs($user)->get("dashboard/orders")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_read_permission_can_view_and_search_orders()
    {
        $user = $this->createUser('admin', ['read_orders']);
        $this->actingAs($user)->get("dashboard/orders")->assertStatus(200);

        $client = factory('App\Client')->create();
        $this->actingAs($user)->get("dashboard/orders?search=$client->name")->assertSee($client->name);
    }

    /** @test */
    public function a_user_without_delete_permission_cannot_delete_orders()
    {
        $user = $this->createUser('admin');
        $order = factory('App\Order')->create();

        $this->actingAs($user)->delete("dashboard/orders/{$order->id}")->assertStatus(403);
    }

    /** @test */
    public function a_user_with_delete_permission_can_delete_orders()
    {
        $user = $this->createUser('admin', ['delete_orders']);
        $order = factory('App\Order')->create();

        $this->actingAs($user)->delete("dashboard/orders/{$order->id}");

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
