<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->user()->id)->get();

        // return $users;

        return view('users.index', compact('users'));
    }

    public function edit($id) 
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $id) 
    {
        $data = $request->validated();

        $user = User::findOrFail($id);

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'User updated successfully!');
    }

    public function statusToggle(Request $request, $id) {
        
    }
}
