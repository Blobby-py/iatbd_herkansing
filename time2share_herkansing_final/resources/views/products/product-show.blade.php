<x-base-layout>
    <div class="mx-4 lg:mx-8">

        <!-- Edit/Delete Product Links and Back Button -->
        <x-product-card class="mt-8 p-4 bg-gray-100 rounded-xl shadow-md">
            <div class="flex justify-center items-center space-x-6">
                <!-- Back Button -->
                <a href="/" class="bg-gray-200 text-primary py-2 px-6 rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>

                <!-- Edit Button -->
                @if (Auth::id() == $product->gebruiker_id)
                <a href="/products/{{ $product->id }}/edit" class="bg-primary text-white py-2 px-6 rounded-xl hover:bg-primary-dark transition-all duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-pencil mr-2"></i> Edit
                </a>
                @endif

                <!-- Delete Button -->
                @if (Auth::id() == $product->gebruiker_id)
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

                <!-- Product Image -->
                <img class="w-40 h-40 object-cover rounded-xl mb-6"
                    src="{{ isset($product->afbeeldingen) && !empty($product->afbeeldingen) ? asset('storage/' . json_decode($product->afbeeldingen)[0]) : asset('/images/no-image.png') }}"
                    alt="Product Image" />

                <h3 class="text-3xl font-semibold text-primary mb-2">{{ $product->titel }}</h3>
                <div class="text-xl font-bold text-gray-700 mb-4">{{ $product->bedrijf }}</div>

                <!-- Tags -->
                <x-product-tags :tagsCsv="$product->tags" class="mb-4" />

                <!-- Location -->
                <div class="text-lg text-gray-600 my-4">
                    <i class="fa-solid fa-location-dot"></i> {{ $product->locatie }}
                </div>

                <div class="border border-gray-200 w-full mb-6"></div>

                <!-- Product Description -->
                <div>
                    <h3 class="text-3xl font-bold mb-4">Product Description</h3>
                    <div class="text-lg text-gray-700 space-y-6">
                        {{ $product->omschrijving }}

                        <!-- Contact Seller Button -->
                        <a href="mailto:{{ $product->email }}" class="block bg-primary text-white mt-6 py-3 rounded-xl hover:bg-primary-dark transition-all duration-200 shadow-md text-center">
                            <i class="fa-solid fa-envelope"></i> Contact Seller
                        </a>

                        <!-- Rent Product Button -->
                        @if(!$product->rentals()->exists()) 
                        <a href="{{ route('products.rent', $product->id) }}" class="block bg-black text-white py-3 rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-md text-center">
                            <i class="fa-solid fa-dollar-sign"></i> Rent Product
                        </a>
                        @else
                        <p class="text-red-500">Dit product is al verhuurd!</p>
                        @endif

                        <!-- Return rented product -->
                        @if($product->rentals()->where('user_id', auth()->id())->exists())
                        <a href="{{ route('products.return', $product->id) }}" class="block bg-red-500 text-white py-3 rounded-xl hover:bg-red-700 transition-all duration-200 shadow-md text-center mt-4">
                            <i class="fa-solid fa-undo mr-2"></i> Product Terugbrengen
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </x-product-card>

        <!-- Add Review Section -->
        @auth
        <x-product-card class="mt-8 p-8 bg-white rounded-xl shadow-xl max-w-2xl mx-auto">
            <h3 class="text-xl font-bold mb-4">Add a Review</h3>
            <form method="POST" action="{{ route('products.reviews.store', $product->id) }}" class="space-y-4">
                @csrf
                <!-- Rating Input -->
                <div>
                    <label for="rating" class="block font-semibold">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <!-- Comment Input -->
                <div>
                    <label for="comment" class="block font-semibold">Comment:</label>
                    <textarea id="comment" name="comment" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary"></textarea>
                </div>

                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark">
                    Submit Review
                </button>
            </form>
        </x-product-card>
        @endauth

        <!-- Reviews Section -->
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
