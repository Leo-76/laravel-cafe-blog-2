@extends('layouts.app')

@section('title', 'Articles — La Cafeotheque')

@section('content')

{{-- Hero / Featured post --}}
@if ($featured && !request('search') && !request('category') && !request('tag'))
    <section class="mb-12">
        <div class="relative rounded-2xl overflow-hidden shadow-xl bg-stone-800 text-white">
            @if ($featured->cover_image)
                <img src="{{ Storage::url($featured->cover_image) }}"
                     alt="{{ $featured->title }}"
                     class="w-full h-80 object-cover opacity-50">
            @else
                <div class="w-full h-80 bg-gradient-to-br from-amber-900 to-stone-900"></div>
            @endif
            <div class="absolute inset-0 flex flex-col justify-end p-8">
                <span class="text-amber-400 text-xs uppercase tracking-widest mb-2">Article a la une</span>
                <h1 class="text-3xl font-bold mb-3 leading-tight">{{ $featured->title }}</h1>
                <p class="text-stone-300 mb-4 max-w-2xl">{{ $featured->excerpt }}</p>
                <a href="{{ route('posts.show', $featured->slug) }}"
                   class="inline-block bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-5 py-2 rounded-lg transition w-fit">
                    Lire l'article
                </a>
            </div>
        </div>
    </section>
@endif

<div class="flex flex-col lg:flex-row gap-10">

    {{-- Post grid --}}
    <section class="flex-1">

        {{-- Search bar --}}
        <form action="{{ route('posts.index') }}" method="GET" class="mb-8 flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Rechercher un article..."
                   class="flex-1 border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            <button type="submit"
                    class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-4 py-2 rounded-lg text-sm transition">
                Rechercher
            </button>
            @if ($search)
                <a href="{{ route('posts.index') }}"
                   class="px-4 py-2 rounded-lg border border-stone-300 text-sm hover:bg-stone-100 transition">
                    Effacer
                </a>
            @endif
        </form>

        @if ($posts->isEmpty())
            <p class="text-stone-500 text-center py-16">Aucun article trouve.</p>
        @else
            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

    {{-- Sidebar --}}
    <aside class="lg:w-64 shrink-0 space-y-8">

        {{-- Categories --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="font-bold text-stone-700 mb-4 uppercase tracking-wide text-xs">Categories</h2>
            <ul class="space-y-2 text-sm">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('posts.index', ['category' => $category->slug]) }}"
                           class="flex justify-between items-center hover:text-amber-600 transition {{ request('category') === $category->slug ? 'text-amber-600 font-semibold' : 'text-stone-600' }}">
                            <span>{{ $category->name }}</span>
                            <span class="bg-stone-100 text-stone-500 text-xs px-2 py-0.5 rounded-full">{{ $category->posts_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Tags --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="font-bold text-stone-700 mb-4 uppercase tracking-wide text-xs">Tags</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}"
                       class="text-xs px-3 py-1 rounded-full border transition
                              {{ request('tag') === $tag->slug
                                 ? 'bg-amber-500 border-amber-500 text-stone-900 font-semibold'
                                 : 'border-stone-300 text-stone-600 hover:border-amber-400 hover:text-amber-600' }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

    </aside>
</div>

@endsection
