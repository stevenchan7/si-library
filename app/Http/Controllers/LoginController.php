<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'password' => ['required', 'max:255']
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user) {
            return back()->withErrors(['credential' => 'No user found']);
        }

        if (Auth::attempt(['username' => $validated['username'], 'password' => $validated['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else {
            return back()->withErrors(['credential' => 'Incorrect password']);
        }
    }
}
