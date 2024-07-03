<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => ['required'],
            'email' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'min:5'],
            'address' => ['required', 'max:255'],
            'phone_number' => ['required', 'numeric']
        ]);

        $validatedData['photo_url'] = 'url';
        $validatedData['role_id'] = 1;
        $validatedData['borrowing_limit'] = 5;
        $validatedData['sex'] = $request->sex;

        //masukkan data ke database
        User::create($validatedData);

        return redirect(route('authenticate'))->with('success', 'Successfully Registered!');
    }
}
