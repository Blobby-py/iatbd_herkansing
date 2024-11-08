<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registreren()
    {
        return view('auth.register');
    }

    public function aanmaken(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $gebruiker = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($gebruiker);

        return redirect('/')->with('status', 'Welkom, je bent nu ingelogd!');
    }

    public function inloggen()
    {
        return view('auth.login');
    }

    public function authenticeren(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($validated)) {
            return redirect('/')->with('status', 'Je bent ingelogd!');
        }

        return back()->withErrors(['email' => 'Onjuiste gegevens.']);
    }

    public function uitloggen()
    {
        Auth::logout();

        return redirect('/')->with('status', 'Je bent uitgelogd.');
    }
}
