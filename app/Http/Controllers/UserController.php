<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        //masukkan data ke database
        $validatedData = $request->validate([
            'role_id' => ['required'],
        ]);
        User::where('id', $user->id)->update($validatedData);

        return redirect(route('users'))->with('success', 'User role has been updated!');
    }
}
