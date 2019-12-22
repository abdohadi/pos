<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
	// use RefreshDatabase;

	/** @test */
	public function it_has_image_path_attribute() 
	{
		$product = factory('App\Product')->create();

		$this->assertEquals($product->image_path, asset('uploads/product_images/' .$product->image));
	}

	/** @test */
	public function it_has_profit_percent_attribute() 
	{
		$product = factory('App\Product')->create();

		$profit = $product->sale_price - $product->purchase_price;
		$profit_percent = $profit * 100 / $product->purchase_price;

		$this->assertEquals($product->profit_percent, $profit_percent);
	}

	/** @test */
	public function it_belongs_to_a_category() 
	{
		$product = factory('App\Product')->create();

		$this->assertInstanceOf('App\Category', $product->category);
	}
}
