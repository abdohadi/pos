<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
   // use RefreshDatabase;

   /** @test */
   public function it_can_have_products()
   {
   	$category = factory('App\Category')->create();

   	$product = factory('App\Product')->create(['category_id' => $category->id]);

   	$this->assertInstanceOf('App\Product', $category->products->first());
   }
}
