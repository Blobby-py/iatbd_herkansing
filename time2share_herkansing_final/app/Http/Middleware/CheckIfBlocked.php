<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Controleer of de gebruiker is ingelogd en geblokkeerd
        if (Auth::check() && Auth::user()->blocked) {
            // Als de gebruiker geblokkeerd is, toon dan een bericht en stop de uitvoering van de request
            return response()->view('products.blocked');
        }

        return $next($request);
    }
}

