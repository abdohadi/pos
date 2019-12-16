<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Role;

class DashboardTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** ## ERROR ##
	* 302 -> bcz of laravel localization middlewares in 'dashboard/web.php' -> ??
    */

    /** @test */
    public function a_user_can_view_dashboard_index()
    {
        // $this->withoutExceptionHandling();
        $user = factory('App\User')->create();

        $this->actingAs($user)->get('dashboard/index')->assertOk();
    }

    /** @test */
    public function a_user_without_read_permission_cannot_view_users()
    {
    	$user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/users')->assertStatus(403);	
    }

    /** @test */
    public function a_user_with_read_permission_can_view_and_search_users()
    {
        $user = $this->createUser('admin', ['read_users']);
        $this->actingAs($user)->get('dashboard/users')->assertStatus(200);

        $newUser = $this->createUser('admin', ['read_users']);
        $this->actingAs($user)->get('dashboard/users?search=' .$newUser->first_name)->assertSee($newUser->first_name);  
    }

    /** @test */
    public function creating_a_user_requires_a_first_name_and_last_name()
    {
        $user = $this->createUser('admin', ['create_users']);

    	$newUser = factory('App\User')->raw(['first_name'=>'', 'last_name'=>'']);

    	$this->actingAs($user)->post('dashboard/users', $newUser)
            ->assertSessionHasErrors(['first_name', 'last_name']);
    }

    /** @test */
    public function creating_a_user_email_validation()
    {
        $user = $this->createUser('admin', ['create_users']);

        // required
    	$newUser = factory('App\User')->raw(['email'=>'']);
    	$this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('email');

        // must be of type email
        $newUser = factory('App\User')->raw(['email'=>'example']);
        $this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('email');

        // must be unique
        factory('App\User')->create(['email'=>'example@example.com']);
        $newUser = factory('App\User')->raw(['email'=>'example@example.com']);
        $this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_a_user_password_validation()
    {
        $user = $this->createUser('admin', ['create_users']);

        // required
    	$newUser = factory('App\User')->raw(['password'=>'']);
    	$this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('password');

        // confirmed
    	$newUser = factory('App\User')->raw(['password'=>'pass', 'password_confirmation'=>'password']);
    	$this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('password');

        // min:8
        $newUser = factory('App\User')->raw(['password'=>'pass']);
        $this->actingAs($user)->post('dashboard/users', $newUser)->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_user_without_create_permission_cannot_create_users()
    {
        $user = $this->createUser('admin');

        $this->actingAs($user)->get('dashboard/users/create')->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_create_permission_can_create_users_with_a_role_and_permissions() 
    {
        $user = $this->createUser('admin', ['create_users']);
        $this->actingAs($user)->get('dashboard/users/create')->assertStatus(200);  

        $newUser = factory('App\User')->make([
            'password' => 'password',
            'password_confirmation' => 'password', 
            'permissions' => ['read_users', 'create_users']
        ]);
        $this->actingAs($user)->post('dashboard/users', $newUser->getAttributes());
    	$this->assertDatabaseHas('users', ['first_name' => $newUser->getAttributes()['first_name']]);

        // Roles and permissions
        $newUser = \App\User::where('email', $newUser->email)->first();
        $this->assertTrue($newUser->isA('admin'));
        $this->assertTrue($newUser->can('read_users'));
    }

    /** @test */
    public function a_user_without_update_permission_cannot_update_users()
    {
        $user = $this->createUser('admin');

        $newUser = $this->createUser('admin', ['read_users', 'create_users']);

        $this->actingAs($user)->get("dashboard/users/{$newUser->id}/edit")->assertStatus(403);  
    }

    /** @test */
    public function a_user_with_update_permission_can_update_users() 
    {
        $user = $this->createUser('admin', ['update_users']);
        $this->actingAs($user)->get("dashboard/users/{$user->id}/edit")->assertStatus(200);  

        $newUser = $this->createUser('admin', ['read_users', 'create_users']);

        $attributes = [
            'first_name' => 'name',
            'last_name' => 'name',
            'email' => 'name@name.com',
            'permissions' => ['read_users', 'update_users']
        ];

        $this->put("dashboard/users/{$newUser->id}", $attributes);
        $this->assertDatabaseHas('users', ['first_name' => $attributes['first_name']]);

        $this->assertTrue($newUser->can('update_users'));
    }

    /** @test */
    public function a_user_without_delete_permission_cannot_delete_users()
    {
        $user = $this->createUser('admin');

        $newUser = $this->createUser('admin', ['read_users', 'create_users']);

        $this->actingAs($user)->delete("dashboard/users/{$newUser->id}")->assertStatus(403);
    }

    /** @test */
    public function a_user_with_delete_permission_can_delete_users()
    {
        $user = $this->createUser('admin', ['delete_users']);

        $newUser = $this->createUser('admin', ['read_users', 'create_users']);

        $this->actingAs($user)->delete("dashboard/users/{$newUser->id}")->assertStatus(200);
    }
}
