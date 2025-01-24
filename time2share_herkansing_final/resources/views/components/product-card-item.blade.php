@props(['product'])

<x-product-card>
    <div class="bg-white p-4 rounded-lg min-w-[300px] max-w-[300px] mx-auto mb-4 flex flex-col min-h-[400px]">
        <!-- Afbeelding -->
        <img class="w-full h-48 object-cover rounded-md mb-4" 
            src="{{ asset('storage/' . json_decode($product->afbeeldingen)[0]) }}" 
            alt="" />

        <div class="text-dark flex flex-col flex-grow">
            <!-- Titel -->
            <h3 class="text-2xl font-semibold mb-2 text-center">
                <a href="{{ route('products.show', $product->id) }}" class="hover:text-primary transition-colors">
                    {{ $product->titel }}
                </a>
            </h3>

            <!-- Prijs onder de titel -->
            <div class="text-xl font-bold text-center text-primary mb-3">
                €{{ number_format($product->prijs, 2, ',', '.') }}
            </div>

            <!-- Categorie -->
            <div class="text-lg font-semibold mb-3 text-center text-dark">{{ $product->categorie }}</div>

            <!-- Locatie met icoontje -->
            <div class="text-md mt-4 text-dark flex items-center justify-center mb-3">
                <i class="fa-solid fa-location-dot mr-2 text-primary"></i>
                <span>{{ $product->locatie }}</span>
            </div>

            <!-- Tags gecentreerd -->
            <div class="flex justify-center mb-3">
                <x-product-tags :tagsCsv="$product->tags" />
            </div>
        </div>

        <!-- Beschrijving met afscheiding -->
        <div class="border-t border-gray-300 pt-3 mt-3 mb-3">
            <p class="text-sm text-center text-dark">{{ Str::limit($product->omschrijving, 100) }}</p>
        </div>
    </div>
</x-product-card>
