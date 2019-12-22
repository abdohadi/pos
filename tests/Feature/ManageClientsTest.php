<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageClientsTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_without_read_permission_cannot_view_clients()
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUser('admin', ['create_clients']);

        $this->actingAs($user)->get('dashboard/clients')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_read_permission_can_view_and_search_clients()
    {
        $this->withoutExceptionHandling();
        $user = $this->createUser('admin', ['read_clients']);
        $this->actingAs($user)->get('dashboard/clients')->assertStatus(200);

        $client = factory('App\Client')->create();
        $this->actingAs($user)->get('dashboard/clients?search=' .$client->name)->assertSee($client->name);  
    }

    /** @test */
    public function there_is_no_route_for_viewing_a_client()
    {
        $user = $this->createUser('admin', ['read_clients']);

        $client = factory('App\Client')->create();
        
        $this->actingAs($user)->get('dashboard/clients/{$client->id}')->assertStatus(404);
    }

    /** @test */
    public function creating_a_client_validation()
    {
        $user = $this->createUser('admin', ['create_clients']);

        $client = factory('App\Client')->raw(['name'=>'', 'phone'=>[], 'address'=>'']);

        $this->actingAs($user)->post('dashboard/clients', $client)
            ->assertSessionHasErrors('name')
            ->assertSessionHasErrors('phone')
            ->assertSessionHasErrors('address');
    }

    /** @test */
    public function a_user_without_create_permission_cannot_create_clients()
    {
        $user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/clients/create')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_create_permission_can_create_clients() 
    {
        $user = $this->createUser('admin', ['create_clients']);

        $this->actingAs($user)->get('dashboard/clients/create')->assertStatus(200);  

        $attributes = factory('App\Client')->create();

        $this->actingAs($user)->post('dashboard/clients', $attributes->toArray());
        
        $this->assertDatabaseHas('clients', ['name' => $attributes->name]);
    }

    /** @test */
    public function a_user_without_update_permission_cannot_update_clients()
    {
        $user = $this->createUser('admin');

        $client = factory('App\Client')->create();

        $this->actingAs($user)->get("dashboard/clients/{$client->id}/edit")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_update_permission_can_update_clients() 
    {
        $user = $this->createUser('admin', ['update_clients']);

        $client = factory('App\Client')->create();
        
        $this->actingAs($user)->get("dashboard/clients/{$client->id}/edit")->assertStatus(200);  

        $attributes = factory('App\Client')->create();

        $this->put("dashboard/clients/{$client->id}", $attributes->toArray());
        
        $this->assertDatabaseHas('clients', ['name' => $attributes->name]);
    }

    /** @test */
    public function a_user_without_delete_permission_cannot_delete_clients()
    {
        $user = $this->createUser('admin');

        $client = factory('App\Client')->create();

        $this->actingAs($user)->delete("dashboard/clients/{$client->id}")->assertStatus(403);
    }

    /** @test */
    public function a_user_with_delete_permission_can_delete_clients()
    {
        $user = $this->createUser('admin', ['delete_clients']);

        $client = factory('App\Client')->create();

        $this->actingAs($user)->delete("dashboard/clients/{$client->id}");

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
