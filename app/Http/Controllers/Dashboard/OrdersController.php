<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrdersController extends Controller
{
	public function __construct() {
		$this->middleware(['permission:read_orders'])->only('index');
		// $this->middleware(['permission:create_orders'])->only('create');
		// $this->middleware(['permission:update_orders'])->only('edit');
		$this->middleware(['permission:delete_orders'])->only('destroy');
	}//end of constructor

	public function index(Request $request) {
		$orders = Order::whereHas('client', function($q) use ($request) {
			return $q->where('name', 'like', '%' .$request->search. '%');
		})->paginate(5);

		return view('dashboard.orders.index', compact('orders'));
	}//end of index

	public function products(Order $order) {
		$products = $order->products;

		return view('dashboard.orders._products', compact(['products', 'order']));
	}

	public function show() {
      abort(404);
	}

	public function store() {
      abort(404);
	}

	public function create() {
      abort(404);
	}

	public function edit() {
      abort(404);
	}

	public function update() {
      abort(404);
	}

	public function destroy(Order $order) {
      foreach ($order->products as $product) {
      	$product->update([
      		'stock' => $product->stock + $product->pivot->quantity
      	]);
      }

      $order->delete();

      session()->flash('success', __('site.deleted_successfully'));

      return redirect()->route('dashboard.orders.index');
	}
}
