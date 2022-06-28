<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index',['users' => $users]);
    }

    public function create()
    {
        if (auth()->user()->cannot('create', User::class)) {
            abort(403,'You are not admin');
        }

        return view('user.create');
    }


    public function store(StoreUserRequest $request)
    {
        if (auth()->user()->cannot('create', User::class)) {
            abort(403);
        }
        User::query()->create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => Hash::make($request->validated()['password'])
        ]);
        return redirect()->route('users.index')->withToastSuccess('User sucessfully created');
    }

    public function show(User $user)
    {
        //
    }


    public function edit(User $user)
    {
        return view('user.edit',['user' => $user]);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => Hash::make($request->validated()['password'])
        ]);
        return redirect()->route('users.index')->withToastSuccess('User sucessfully updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->withToastSuccess('User sucessfully deleted');
    }




}

