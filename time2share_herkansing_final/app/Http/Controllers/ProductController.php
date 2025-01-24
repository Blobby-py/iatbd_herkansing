<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
     
        $tag = $request->get('tag');
        
        if ($tag && !empty($tag)) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }
    
        $producten = $query->paginate(10);
    
        return view('products.product-list', compact('producten', 'tag')); 
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // filter on searchterm
        $producten = Product::filter(['zoekterm' => $query])->paginate(10);

        return view('products.product-list', compact('producten', 'query'));
    }

    public function create()
    {
        return view('products.product-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'locatie' => 'required|string|max:255',
            'email' => 'required|email',
            'tags' => 'nullable|string',
            'prijs' => 'required|numeric',
            'afbeeldingen' => 'nullable|array',
            'afbeeldingen.*' => 'image|mimes:jpeg,png,jpg,gif',
            'omschrijving' => 'required|string',
        ]);
    
        if ($request->hasFile('afbeeldingen')) {
            $afbeeldingen = $request->file('afbeeldingen');
            $afbeeldingenPaden = [];
    
            foreach ($afbeeldingen as $afbeelding) {
                $afbeeldingenPaden[] = $afbeelding->store('afbeeldingen', 'public');
            }
    
            $validated['afbeeldingen'] = json_encode($afbeeldingenPaden);
        }
    
        $validated['gebruiker_id'] = auth()->id();
    
        Product::create($validated);
    
        $producten = Product::paginate(10);
    
        return view('products.product-list', compact('producten'));
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'locatie' => 'required|string|max:255',
            'email' => 'required|email',
            'tags' => 'nullable|string',
            'prijs' => 'required|numeric',
            'afbeeldingen' => 'nullable|array',
            'afbeeldingen.*' => 'image|mimes:jpeg,png,jpg,gif',
            'omschrijving' => 'required|string',
        ]);
    
        $product->titel = $validated['titel'];
        $product->locatie = $validated['locatie'];
        $product->email = $validated['email'];
        $product->tags = $validated['tags'] ?? '';
        $product->prijs = $validated['prijs'];
        $product->omschrijving = $validated['omschrijving'];
    
        if ($request->hasFile('afbeeldingen')) {
            $afbeeldingen = $request->file('afbeeldingen');
            $afbeeldingenPaden = [];
    
            foreach ($afbeeldingen as $afbeelding) {
                $afbeeldingenPaden[] = $afbeelding->store('afbeeldingen', 'public');
            }
    
            $product->afbeeldingen = json_encode($afbeeldingenPaden);
        }
    
        $product->save();
    
        return redirect('/')->with('success', 'Product succesvol bijgewerkt!');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect('/')->with('success', 'Product succesvol verwijderd!');
    }

    public function show(Product $product)
    {
        $rental = $product->rentals()->latest()->first();
        $daysLeft = null;
    
        if ($rental) {
            $daysLeft = now()->diffInDays($rental->due_at, false);
        }
    
        return view('products.product-show', compact('product', 'daysLeft'));
    }

    public function edit(Product $product)
    {
        return view('products.product-edit', compact('product'));
    }

    public function returnProduct(Request $request, Product $product)
    {
        $rental = Rent::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($rental) {
            $rental->delete();
            return redirect()->route('products.show', $product->id)->with('success', 'Je hebt dit product succesvol teruggebracht!');
        } else {
            return redirect()->route('products.show', $product->id)->with('error', 'Je hebt dit product niet gehuurd!');
        }
    }

    public function rent($id)
    {
        $product = Product::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet inloggen om dit product te huren!');
        }

        if ($product->rentals()->exists()) {
            return redirect()->route('products.show', $product->id)->with('error', 'Dit product is al verhuurd!');
        }

        if ($product->rentals()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('products.show', $product->id)->with('error', 'Je hebt dit product al gehuurd!');
        }

        $rental = new Rent([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rented_at' => now(),
            'due_at' => now()->addWeeks(1),
        ]);

        $rental->save();

        return redirect()->route('products.show', $product->id)->with('message', 'Je hebt dit product succesvol gehuurd!');
    }
}
