<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Client;
use App\Product;
use App\Order;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
    }

    public function index() {
      abort(404);
    }

    public function create(Client $client)
    {
        $categories = Category::all();
        $orders = $client->orders()->with('products')->latest()->paginate(5);
        
        return view('dashboard.clients.orders.create', compact(['client', 'categories', 'orders']));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $total_price = 0;

        $order = $client->orders()->create();

        // a better way than foreach
        $order->products()->attach($request->products);


        foreach ($request->products as $id=>$quantity_array) {
            $product = Product::findOrFail($id);

            $total_price += $product->sale_price * $quantity_array['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity_array['quantity']
            ]);
        }

        $order->update([
            'total_price' => $total_price
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.orders.index');
    }

    public function show() {
        abort(404);
    }

    public function edit(Client $client, Order $order) {
        $categories = Category::all();
        $orders = $client->orders()->with('products')->latest()->paginate(6);

        return view('dashboard.clients.orders.edit', compact(['order', 'client', 'categories', 'orders']));
    }

    public function update(Request $request, Client $client, Order $order) {
        ///////////////// we could've just detached the old order and attached the new one //////////////
        $request->validate([
            'products' => 'required|array',
        ]);

        $total_price = 0;

        foreach ($request->products as $id=>$quantity_array) {
            $product = Product::findOrFail($id);
            $pivot = $order->products->find($id)->pivot;

            $product->update([
                // stock - (new - old) --> ex: 17-(2-3) / 17-(5-3)
                'stock' => $product->stock - ($quantity_array['quantity'] - $pivot->quantity)
            ]);

            $pivot->update([
                'quantity' => $quantity_array['quantity']
            ]);

            $total_price += $product->sale_price * $quantity_array['quantity'];
        }

        $order->update([
            'total_price' => $total_price
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.orders.index');
    }

    public function destroy() {
        abort(404);
    }
}
