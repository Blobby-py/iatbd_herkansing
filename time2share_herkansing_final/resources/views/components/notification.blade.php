@if(session()->has('alert'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-primary text-dark px-12 py-3 rounded-lg shadow-lg">
        <p class="font-semibold">
            {{ session('alert') }}
        </p>
    </div>
@endif
