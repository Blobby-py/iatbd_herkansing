<x-base-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">My Profile</h2>
        
        <!-- Gebruikersinformatie -->
        <div class="mb-8">
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        </div>

        <!-- Overzicht van geposte producten -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">My Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($producten as $product)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="font-bold text-lg mb-2">{{ $product->titel }}</h4>
                        <p class="text-sm mb-2">{{ $product->omschrijving }}</p>
                        <p><strong>Price:</strong> €{{ $product->prijs }}</p>
                        <p><strong>Location:</strong> {{ $product->locatie }}</p>
                        
                        <!-- Controleer of het product is uitgeleend -->
                        @if($product->rentals()->exists())
                            <p class="text-red-500 font-bold">Currently rented out to: {{ $product->rentals->first()->user->name }}</p>
                        @else
                            <p class="text-green-500 font-bold">Available for rent</p>
                        @endif

                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-500 hover:underline mt-4 block">View Product</a>
                    </div>
                @empty
                    <p>You haven't posted any products yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Overzicht van ontvangen reviews -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">My Reviews</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($reviews as $review)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p><strong>Review For:</strong> {{ $review->product->titel }}</p>
                        <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                        <p><strong>Comment:</strong> {{ $review->comment }}</p>
                        <p><strong>Review by:</strong> {{ $review->user->name }}</p>
                    </div>
                @empty
                    <p>You don't have any reviews yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-base-layout>
