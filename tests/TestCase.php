<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser($roleName, $perms = []) {
    	$config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));
        $userName = explode('_', $roleName);

        if (! array_key_exists($roleName, $config)) return 'No such role';

	    // Create a new role if not exist
        if (! $role = \App\Role::where('name', $roleName)->first()) {
            $role = \App\Role::create([
                'name' => $roleName,
                'display_name' => ucwords(str_replace('_', ' ', $roleName)),
                'description' => ucwords(str_replace('_', ' ', $roleName))
            ]);
        }
        $permissions = [];

        foreach ($config as $key => $modules) {
	        // Reading role permission modules
            if ($key == $roleName) {        // just get permissions of the role we specified

	           foreach ($modules as $module => $value) {

    	            foreach (explode(',', $value) as $p => $perm) {

    	                $permissionValue = $mapPermission->get($perm);

    	                $permissions[] = \App\Permission::firstOrCreate([
    	                    'name' => $permissionValue . '_' . $module,     // i changed it from '-' -> '_'
    	                    'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    	                    'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
    	                ])->id;
    	            }
                }
	        }
	    }

        if ($perms) {
            foreach ($perms as $p) {
                $permissions[] = \App\Permission::firstOrCreate([
                    'name' => $p,
                    'display_name' => ucfirst(explode('_', $p)[0]) . ' ' . ucfirst(explode('_', $p)[1]),
                    'description' => ucfirst(explode('_', $p)[0]) . ' ' . ucfirst(explode('_', $p)[1]),
                ])->id;
            }
        }

        // Attach all permissions to the role

        $role->permissions()->sync($permissions);

        // Create a user
    	$user = \App\User::create([
        	'first_name' => $userName[0],
        	'last_name' => $userName[1] ?? $userName[0],
        	'email' => $roleName.rand().'@app.com',
        	'password' => bcrypt('123456')
        ]);

        // Attach the role to the user
        $user->attachRole($roleName);

        // Attach all permissions to the user
        $user->permissions()->sync($permissions);
        
        return $user;
    }
}
