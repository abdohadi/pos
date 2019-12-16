<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->when($request->search, function($q) use ($request) {
            return $q->where('first_name', 'like', '%' .$request->search. '%')
                ->orWhere('last_name', 'like', '%' .$request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        // validation
        $validated_data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);

        // creating the user
        $attributes = $request->except(['password', 'password_confirmation', 'permissions']);
        $attributes['password'] = bcrypt($request->password);
        if ($validated_data) $user = User::create($attributes);

        // attaching a role and permissions
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        // setting a flash msg
        session()->flash('success', __('site.added_successfully'));

        // redirection
        return redirect(route('dashboard.users.index')); 
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // validation
        $validated_data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users'    //%%%%% how can we leave the email without updating?
        ]);

        // creating the user
        $attributes = $request->except(['permissions']);
        if ($validated_data) $user->update($attributes);

        // attaching permissions
        $user->syncPermissions($request->permissions);

        // setting a flash msg
        session()->flash('success', __('site.updated_successfully'));

        // redirection
        return redirect(route('dashboard.users.index'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.users.index');
    }
}
