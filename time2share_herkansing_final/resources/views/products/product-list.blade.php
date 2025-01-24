<x-base-layout>
    <!-- Zoekbalk en hero component -->
    @include('components.search')
    @include('components.hero')

    <!-- Producten Lijst -->
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @unless(empty($producten) || count($producten) == 0)
            @foreach($producten as $product)
                <x-product-card-item :product="$product" />
            @endforeach
        @else
            <p>No rental products found :' (</p>
        @endunless
    </div>

    <!-- Paginering -->
    <div class="mt-6 p-4">
        {{ $producten->appends(['query' => request('query'), 'tag' => request('tag')])->links() }}
    </div>
</x-base-layout>
