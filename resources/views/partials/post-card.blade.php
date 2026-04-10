<article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition flex flex-col">

    {{-- Cover --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-video overflow-hidden bg-stone-200">
        @if ($post->cover_image)
            <img src="{{ Storage::url($post->cover_image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full bg-gradient-to-br from-amber-100 to-stone-200 flex items-center justify-center">
                <span class="text-stone-400 text-4xl font-serif">C</span>
            </div>
        @endif
    </a>

    {{-- Content --}}
    <div class="p-5 flex flex-col flex-1">
        @if ($post->category)
            <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
               class="text-xs font-semibold uppercase tracking-widest text-amber-600 mb-2 inline-block">
                {{ $post->category->name }}
            </a>
        @endif

        <h3 class="font-bold text-stone-800 text-lg leading-snug mb-2">
            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-amber-600 transition">
                {{ $post->title }}
            </a>
        </h3>

        @if ($post->excerpt)
            <p class="text-stone-500 text-sm leading-relaxed mb-4 flex-1">
                {{ Str::limit($post->excerpt, 120) }}
            </p>
        @endif

        <div class="flex items-center justify-between text-xs text-stone-400 mt-auto pt-3 border-t border-stone-100">
            <span>{{ $post->author->name }}</span>
            <span>{{ $post->published_at->translatedFormat('d M Y') }}</span>
        </div>
    </div>

</article>
