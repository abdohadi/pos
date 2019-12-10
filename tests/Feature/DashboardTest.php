<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_view_dashboard_index()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create())->get('dashboard/index')->assertOk();
    }
}
