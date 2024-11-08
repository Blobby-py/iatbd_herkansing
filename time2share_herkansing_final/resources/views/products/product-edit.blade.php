<x-base-layout>

    <div class="mx-4 lg:mx-8">
        <x-product-card class="p-8 bg-white rounded-xl shadow-xl max-w-3xl mx-auto">
            <form method="POST" action="/products/{{ $product->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3 class="text-3xl font-semibold text-primary mb-4">Edit Product</h3>

                    <!-- Titel -->
                    <div>
                        <label for="titel" class="block text-lg font-semibold">Title</label>
                        <input type="text" id="titel" name="titel" value="{{ old('titel', $product->titel) }}" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    </div>

                    <!-- Locatie -->
                    <div>
                        <label for="locatie" class="block text-lg font-semibold">Location</label>
                        <input type="text" id="locatie" name="locatie" value="{{ old('locatie', $product->locatie) }}" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-lg font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $product->email) }}" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    </div>

                    <!-- Prijs -->
                    <div>
                        <label for="prijs" class="block text-lg font-semibold">Price</label>
                        <input type="number" id="prijs" name="prijs" value="{{ old('prijs', $product->prijs) }}" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    </div>

                    <!-- Afbeeldingen -->
                    <div>
                        <label for="afbeeldingen" class="block text-lg font-semibold">Images</label>
                        <input type="file" id="afbeeldingen" name="afbeeldingen[]" multiple class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Omschrijving -->
                    <div>
                        <label for="omschrijving" class="block text-lg font-semibold">Description</label>
                        <textarea id="omschrijving" name="omschrijving" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>{{ old('omschrijving', $product->omschrijving) }}</textarea>
                    </div>

                    <!-- Knoppen onderin -->
                    <div class="flex justify-center space-x-6 mt-6">
                        <a href="/products/{{ $product->id }}" class="bg-gray-200 text-primary py-2 px-6 rounded-xl hover:bg-gray-300 transition-all duration-200">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="bg-primary text-white py-2 px-6 rounded-xl hover:bg-primary-dark transition-all duration-200 shadow-md">
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </x-product-card>
    </div>
</x-base-layout>
