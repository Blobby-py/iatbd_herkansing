<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

        $producten = Product::where('titel', 'like', '%' . $query . '%')
                            ->orWhere('omschrijving', 'like', '%' . $query . '%')
                            ->paginate(10);

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
    
        return redirect('/')->with('success', 'Product succesvol bijgewerkt!');
    }

    public function show(Product $product)
    {
        return view('products.product-show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.product-edit', compact('product'));
    }
}
