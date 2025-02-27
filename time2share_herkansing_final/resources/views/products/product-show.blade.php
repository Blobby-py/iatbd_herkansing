<x-base-layout>
    <div class="mx-4 lg:mx-8">

        <x-product-card class="mt-8 p-4 bg-gray-100 rounded-xl shadow-md">
            <div class="flex justify-center items-center space-x-6">
                <a href="/" class="bg-gray-200 text-primary py-2 px-6 rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>

                @if(auth()->check() && (auth()->user()->id === $product->gebruiker_id || auth()->user()->email === 'admin@example.com'))
                    <a href="/products/{{ $product->id }}/edit" class="bg-primary text-white py-2 px-6 rounded-xl hover:bg-primary-dark transition-all duration-200 flex items-center justify-center">
                        <i class="fa-solid fa-pencil mr-2"></i> Edit
                    </a>
                @endif

                @if(auth()->check() && (auth()->user()->id === $product->gebruiker_id || auth()->user()->email === 'admin@example.com'))
                    <form method="POST" action="/products/{{ $product->id }}" class="flex items-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-2 px-6 rounded-xl hover:bg-red-600 transition-all duration-200 flex items-center justify-center">
                            <i class="fa-solid fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                @endif
            </div>
        </x-product-card>

        <x-product-card class="p-8 bg-white rounded-xl shadow-xl max-w-2xl mx-auto">
            <div class="flex flex-col items-center justify-center text-center space-y-6">

                <img class="w-40 h-40 object-cover rounded-xl mb-6"
                    src="{{ isset($product->afbeeldingen) && !empty($product->afbeeldingen) ? asset('storage/' . json_decode($product->afbeeldingen)[0]) : asset('/images/no-image.png') }}"
                    alt="Product Image" />

                <h3 class="text-3xl font-semibold text-primary mb-2">{{ $product->titel }}</h3>
                <div class="text-xl font-bold text-gray-700 mb-4">{{ $product->bedrijf }}</div>

                <x-product-tags :tagsCsv="$product->tags" class="mb-4" />

                <div class="text-lg text-gray-600 my-4">
                    <i class="fa-solid fa-location-dot"></i> {{ $product->locatie }}
                </div>

                <div class="border border-gray-200 w-full mb-6"></div>

                <div>
                    <h3 class="text-3xl font-bold mb-4">Product Description</h3>
                    <div class="text-lg text-gray-700 space-y-6">
                        {{ $product->omschrijving }}

                        <a href="mailto:{{ $product->email }}" class="block bg-primary text-white mt-6 py-3 rounded-xl hover:bg-primary-dark transition-all duration-200 shadow-md text-center">
                            <i class="fa-solid fa-envelope"></i> Contact Seller
                        </a>

                        @if ($product->rentals()->exists())
                            <p class="text-red-500">
                                This product is currently rented!
                                @if ($daysLeft !== null && $daysLeft > 0)
                                    <br>Available in {{ $daysLeft }} day(s).
                                @elseif ($daysLeft === 0)
                                    <br>Available Today
                                @else
                                    <br>Rental period has ended. Contact the owner.
                                @endif
                            </p>
                        @else
                            @auth
                                <a href="{{ route('products.rent', $product->id) }}" class="block bg-green-500 text-white mt-6 py-3 rounded-xl hover:bg-green-700 transition-all duration-200 shadow-md text-center">
                                    Rent Product
                                </a>
                            @else
                                <p class="mt-4">
                                    <a href="{{ route('login') }}" class="text-blue-500 underline">Log in</a> to rent this product.
                                </p>
                            @endauth
                        @endif

                        @if ($product->rentals()->where('user_id', auth()->id())->exists())
                            <a href="{{ route('products.return', $product->id) }}" class="block bg-red-500 text-white py-3 rounded-xl hover:bg-red-700 transition-all duration-200 shadow-md text-center mt-4">
                                <i class="fa-solid fa-undo mr-2"></i> Return Product
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </x-product-card>

        @auth
        <x-product-card class="mt-8 p-8 bg-white rounded-xl shadow-xl max-w-2xl mx-auto">
            <h3 class="text-2xl font-bold mb-6">Add a Review</h3>
            <form method="POST" action="{{ route('products.reviews.store', $product->id) }}" class="space-y-6">
                @csrf
                <div>
                    <label for="rating" class="block font-semibold text-lg">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-3 text-lg">
                </div>
                <div>
                    <label for="comment" class="block font-semibold text-lg">Comment:</label>
                    <textarea id="comment" name="comment" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-3 text-lg"></textarea>
                </div>
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-all duration-200 shadow-md w-full">Submit Review</button>
            </form>
        </x-product-card>
        @endauth

        @if($product->reviews->count())
        <x-product-card class="mt-8 p-8 bg-gray-100 rounded-xl shadow-md max-w-2xl mx-auto">
            <h3 class="text-xl font-bold mb-4">Reviews</h3>
            <ul class="space-y-4">
                @foreach($product->reviews as $review)
                <li class="bg-white p-4 shadow rounded-lg">
                    <div class="flex justify-between">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <span class="text-primary font-bold">{{ $review->rating }}/5</span>
                    </div>
                    <p class="mt-2">{{ $review->comment }}</p>
                </li>
                @endforeach
            </ul>
        </x-product-card>
        @endif

    </div>
</x-base-layout>