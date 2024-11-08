<x-base-layout>
    <x-product-card class="p-12 w-[80vw] mx-auto mt-24 bg-white rounded-xl shadow-xl">
        <header class="text-center mb-10">
            <h2 class="text-4xl font-semibold text-primary mb-3">Post a Rental Product</h2>
            <p class="text-lg text-gray-500">Share your product for rent and find a renter.</p>
        </header>

        <!-- Formulier om een nieuw product toe te voegen -->
        <form method="POST" action="/products" enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- Product Title -->
            <div class="mb-10">
                <label for="titel" class="text-lg font-medium text-gray-700 mb-2 block">Product Title</label>
                <input type="text" id="titel" name="titel" placeholder="Example: High-end Laptop"
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out"
                    value="{{ old('titel') }}" />
                @error("titel") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-10">
                <label for="locatie" class="text-lg font-medium text-gray-700 mb-2 block">Location</label>
                <input type="text" id="locatie" name="locatie" placeholder="Example: New York, NY"
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out"
                    value="{{ old('locatie') }}" />
                @error("locatie") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Contact Email -->
            <div class="mb-10">
                <label for="email" class="text-lg font-medium text-gray-700 mb-2 block">Contact Email</label>
                <input type="email" id="email" name="email" 
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out"
                    value="{{ old('email') }}" />
                @error("email") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-10">
                <label for="tags" class="text-lg font-medium text-gray-700 mb-2 block">Tags (Comma Separated)</label>
                <input type="text" id="tags" name="tags" placeholder="Example: Laptop, Electronics, Rent"
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out"
                    value="{{ old('tags') }}" />
                @error("tags") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Rental Price -->
            <div class="mb-10">
                <label for="prijs" class="text-lg font-medium text-gray-700 mb-2 block">Rental Price (per day)</label>
                <input type="text" id="prijs" name="prijs" placeholder="Example: 50"
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out"
                    value="{{ old('prijs') }}" />
                @error("prijs") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Product Images -->
            <div class="mb-10">
                <label for="afbeeldingen" class="text-lg font-medium text-gray-700 mb-2 block">Product Images</label>
                <input type="file" id="afbeeldingen" name="afbeeldingen[]" multiple
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out" />
                @error('afbeeldingen') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Product Description -->
            <div class="mb-10">
                <label for="omschrijving" class="text-lg font-medium text-gray-700 mb-2 block">Product Description</label>
                <textarea id="omschrijving" name="omschrijving" rows="6" placeholder="Include features, rental price, etc."
                    class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:border-primary shadow-md transition-all ease-in-out">{{ old('omschrijving') }}</textarea>
                @error("omschrijving") 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Form Action Buttons -->
            <div class="flex justify-center items-center mt-8 space-x-4">
                <a href="/" class="text-primary text-lg font-semibold hover:text-primary-dark transition-all duration-200">Back</a>
                <button type="submit" class="bg-primary text-white rounded-xl py-3 px-8 hover:bg-primary-dark transition-all duration-200 shadow-md">
                    Post Product
                </button>
            </div>

        </form>
    </x-product-card>
</x-base-layout>
