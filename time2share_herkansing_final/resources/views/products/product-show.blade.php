<x-base-layout>

    <div class="mx-4 lg:mx-8">
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
                        <a href="{{ $product->website }}" target="_blank" class="block bg-black text-white py-3 rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-md text-center">
                            <i class="fa-solid fa-dollar-sign"></i> Rent Product
                        </a>
                    </div>
                </div>
            </div>
        </x-product-card>

        <!-- Edit/Delete Product Links and Back Button -->
        <x-product-card class="mt-8 p-4 bg-gray-100 rounded-xl shadow-md">
            <div class="flex justify-center items-center space-x-6">
                <!-- Back Button -->
                <a href="/" class="bg-gray-200 text-primary py-2 px-6 rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>

                <!-- Edit Button -->
                <a href="/products/{{ $product->id }}/edit" class="bg-primary text-white py-2 px-6 rounded-xl hover:bg-primary-dark transition-all duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-pencil mr-2"></i> Edit
                </a>

                <!-- Delete Button -->
                <form method="POST" action="/products/{{ $product->id }}" class="flex items-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white py-2 px-6 rounded-xl hover:bg-red-600 transition-all duration-200 flex items-center justify-center">
                        <i class="fa-solid fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </x-product-card>
    </div>
</x-base-layout>
