@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' — La Cafeotheque')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
<article class="max-w-3xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-600">Accueil</a>
        <span class="mx-2">/</span>
        @if ($post->category)
            <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
               class="hover:text-amber-600">{{ $post->category->name }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-stone-700">{{ Str::limit($post->title, 50) }}</span>
    </nav>

    {{-- Cover image --}}
    @if ($post->cover_image)
        <img src="{{ Storage::url($post->cover_image) }}"
             alt="{{ $post->title }}"
             class="w-full h-72 object-cover rounded-2xl shadow mb-8">
    @endif

    {{-- Header --}}
    <header class="mb-8">
        @if ($post->category)
            <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
               class="inline-block text-xs font-semibold uppercase tracking-widest text-amber-600 mb-3">
                {{ $post->category->name }}
            </a>
        @endif

        <h1 class="text-4xl font-bold leading-tight text-stone-900 mb-4">{{ $post->title }}</h1>

        <div class="flex items-center gap-4 text-sm text-stone-500">
            <span>Par <strong class="text-stone-700">{{ $post->author->name }}</strong></span>
            <span>&bull;</span>
            <time datetime="{{ $post->published_at->toIso8601String() }}">
                {{ $post->published_at->translatedFormat('d F Y') }}
            </time>
            <span>&bull;</span>
            <span>{{ $post->readingTime() }} min de lecture</span>
        </div>

        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}"
                       class="text-xs px-3 py-1 rounded-full border border-stone-300 text-stone-600 hover:border-amber-400 hover:text-amber-600 transition">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </header>

    {{-- Body --}}
    <div class="prose prose-stone prose-lg max-w-none mb-12">
        {!! $post->body !!}
    </div>

    {{-- Author bio --}}
    <div class="bg-stone-100 rounded-xl p-6 flex gap-4 items-start mb-12">
        @if ($post->author->avatar)
            <img src="{{ Storage::url($post->author->avatar) }}"
                 alt="{{ $post->author->name }}"
                 class="w-14 h-14 rounded-full object-cover shrink-0">
        @else
            <div class="w-14 h-14 rounded-full bg-amber-200 flex items-center justify-center text-amber-800 font-bold text-xl shrink-0">
                {{ strtoupper(substr($post->author->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <p class="font-bold text-stone-800">{{ $post->author->name }}</p>
            @if ($post->author->bio)
                <p class="text-stone-600 text-sm mt-1">{{ $post->author->bio }}</p>
            @endif
        </div>
    </div>

    {{-- Comments --}}
    <section id="commentaires">
        <h2 class="text-2xl font-bold mb-6">
            Commentaires ({{ $post->approvedComments->count() }})
        </h2>

        @if ($post->approvedComments->isEmpty())
            <p class="text-stone-500 mb-8">Soyez le premier a commenter cet article.</p>
        @else
            <div class="space-y-6 mb-10">
                @foreach ($post->approvedComments as $comment)
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-stone-700">{{ $comment->displayName() }}</span>
                            <span class="text-xs text-stone-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-stone-600 text-sm leading-relaxed">{{ $comment->body }}</p>
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Supprimer</button>
                            </form>
                        @endcan
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Comment form --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4">Laisser un commentaire</h3>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('comments.store', $post) }}" method="POST" class="space-y-4">
                @csrf

                @guest
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Nom *</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                                   class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Email *</label>
                            <input type="email" name="guest_email" value="{{ old('guest_email') }}" required
                                   class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                    </div>
                    <p class="text-xs text-stone-500">Votre email ne sera pas publie. Votre commentaire sera soumis a moderation.</p>
                @endguest

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Commentaire *</label>
                    <textarea name="body" rows="4" required
                              class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">{{ old('body') }}</textarea>
                </div>

                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Publier le commentaire
                </button>
            </form>
        </div>
    </section>
</article>

{{-- Related posts --}}
@if ($related->isNotEmpty())
    <section class="mt-16 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Articles similaires</h2>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($related as $relatedPost)
                @include('partials.post-card', ['post' => $relatedPost])
            @endforeach
        </div>
    </section>
@endif

@endsection
