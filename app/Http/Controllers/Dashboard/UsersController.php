<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Storage;
use Illuminate\Validation\Rule;

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
        $users = User::whereRoleIs('admin')->where(function($query) use ($request) {
            return $query->when($request->search, function($q) use ($request) {
                return $q->where('first_name', 'like', '%' .$request->search. '%')
                    ->orWhere('last_name', 'like', '%' .$request->search. '%');
            });
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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|min:8',
            'image' => 'image|mimes:png,jpg,jpeg,gif|max:2048',
            'permissions' => 'required|min:1',
        ]);

        $attributes = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $attributes['password'] = bcrypt($request->password);

        // prepare the img
        if ($request->image) {
            // handel(compress and save) the image
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' .$request->image->hashName()));

            $attributes['image'] = $request->image->hashName();
        }

        // creating the user
        $user = User::create($attributes);

        // attaching a role and permissions
        $user->attachRole('admin');
        if ($request->permissions) $user->syncPermissions($request->permissions);

        // setting a flash msg
        session()->flash('success', __('site.added_successfully'));

        // redirection
        return redirect(route('dashboard.users.index')); 
    }

    public function show(User $user)
    {
        return abort(404);
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'permissions' => 'required|min:1',
        ]);

        $attributes = $request->except(['permissions', 'image']);

        if ($request->image) {
            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' .$user->image);
            }

            // handel(compress and save) the image
            Image::make($request->image)
                ->resize(300, null, function($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' .$request->image->hashName()));

            $attributes['image'] = $request->image->hashName();
        }

        // update the user
        $user->update($attributes);

        // attaching permissions
        if ($request->permissions) $user->syncPermissions($request->permissions);

        // setting a flash msg
        session()->flash('success', __('site.updated_successfully'));

        // redirection
        return redirect(route('dashboard.users.index'));
    }

    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' .$user->image);
        }

        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.users.index');
    }
}
