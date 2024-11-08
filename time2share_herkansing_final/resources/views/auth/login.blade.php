<x-base-layout>
    <x-product-card class="p-10 max-w-lg mx-auto mt-24 bg-white rounded-xl shadow-xl">
        <header class="text-center mb-8">
            <h2 class="text-3xl font-semibold text-primary mb-3">Login</h2>
            <p class="text-lg text-gray-500">Log into your account to rent products</p>
        </header>

        <form method="POST" action="/users/authenticate" class="space-y-8">
            @csrf

            <div class="mb-6">
                <label for="email" class="text-lg font-medium text-gray-700 mb-2 block">Email Address</label>
                <input type="email" id="email" class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent shadow-md transition-all ease-in-out"
                    name="email" value="{{ old('email') }}" />
                @error("email")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="text-lg font-medium text-gray-700 mb-2 block">Password</label>
                <input type="password" id="password" class="border border-gray-300 rounded-xl p-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent shadow-md transition-all ease-in-out"
                    name="password" />
                @error("password")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-primary text-white rounded-xl py-3 px-8 hover:bg-primary-dark transition-all duration-200 shadow-md w-full">
                    Sign In
                </button>
            </div>

            <div class="mt-8 text-center">
                <p>Don't have an account? <a href="/register" class="text-primary hover:text-primary-dark">Register here</a></p>
            </div>
        </form>
    </x-product-card>
</x-base-layout>
