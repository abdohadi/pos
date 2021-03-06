<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_clients'])->only('index');
        $this->middleware(['permission:create_clients'])->only('create');
        $this->middleware(['permission:update_clients'])->only('edit');
        $this->middleware(['permission:delete_clients'])->only('destroy');
    }

    public function index(Request $request)
    {
        $clients = Client::when($request->search, function($q) use ($request) {
            return $q->where('name', 'like', '%' .$request->search. '%')
                    ->orWhere('phone', 'like', '%' .$request->search. '%')
                    ->orWhere('address', 'like', '%' .$request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);

        $attributes = $request->all();
        $attributes['phone'] = array_filter($request->phone);

        Client::create($attributes);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.clients.index');
    }

    public function show(Client $client)
    {
        return abort(404);
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);

        $attributes = $request->all();
        $attributes['phone'] = array_filter($request->phone);
        $client->update($attributes);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.clients.index');
    }
}
