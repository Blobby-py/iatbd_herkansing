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

    public function profile()
    {
        $user = auth()->user();
    
        if ($user->email === 'admin@example.com') {
            $gebruikers = User::where('email', '!=', 'admin@example.com')->get();
            return view('components.admin-profile', compact('user', 'gebruikers'));
        }
    
        $producten = $user->products;
        $reviews = $user->receivedReviews()->with('product', 'user')->get();
    
        return view('components.profile', compact('user', 'reviews', 'producten'));
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

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);

        $user->blocked = !$user->blocked;
        $user->save();

        return back()->with('status', $user->blocked ? 'Gebruiker is geblokkeerd.' : 'Gebruiker is degeblookeerd.');
    }
}
