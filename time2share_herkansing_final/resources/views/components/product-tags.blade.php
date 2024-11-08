@props(["tagsCsv"])

@php
    $tags = explode(",", $tagsCsv);
@endphp

<ul class="flex flex-wrap">
    @foreach($tags as $tag)
        <li class="mr-2 mb-2">
            <a href="?tag={{$tag}}" class="inline-block bg-primary text-white rounded-full py-2 px-4 text-sm font-semibold hover:bg-gray-800 hover:text-white transition-all duration-200">
                {{ $tag }}
            </a>
        </li>
    @endforeach
</ul>
