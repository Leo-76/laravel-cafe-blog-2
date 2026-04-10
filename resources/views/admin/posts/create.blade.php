@extends('layouts.app')

@section('title', isset($post) ? 'Editer : ' . $post->title : 'Nouvel article')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-8">
        {{ isset($post) ? 'Modifier l\'article' : 'Nouvel article' }}
    </h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6 bg-white rounded-xl shadow-sm p-8">
        @csrf
        @isset($post) @method('PUT') @endisset

        {{-- Title --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Titre *</label>
            <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required
                   class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        {{-- Slug --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Slug (URL)</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}"
                   class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400 font-mono text-sm">
            <p class="text-xs text-stone-400 mt-1">Laisser vide pour generer automatiquement depuis le titre.</p>
        </div>

        {{-- Excerpt --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Extrait</label>
            <textarea name="excerpt" rows="2"
                      class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>

        {{-- Body --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Contenu *</label>
            <textarea name="body" rows="18" required
                      class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm font-mono">{{ old('body', $post->body ?? '') }}</textarea>
            <p class="text-xs text-stone-400 mt-1">HTML accepte.</p>
        </div>

        {{-- Category + Published at --}}
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Categorie</label>
                <select name="category_id"
                        class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">
                    <option value="">-- Aucune --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Date de publication</label>
                <input type="datetime-local"
                       name="published_at"
                       value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">
                <p class="text-xs text-stone-400 mt-1">Laisser vide pour enregistrer en brouillon.</p>
            </div>
        </div>

        {{-- Tags --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-2">Tags</label>
            <div class="flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <label class="flex items-center gap-1.5 text-sm cursor-pointer">
                        <input type="checkbox"
                               name="tags[]"
                               value="{{ $tag->id }}"
                               {{ (collect(old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : []))->contains($tag->id)) ? 'checked' : '' }}
                               class="rounded border-stone-300 text-amber-500 focus:ring-amber-400">
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Cover image --}}
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Image de couverture</label>
            @if (isset($post) && $post->cover_image)
                <img src="{{ Storage::url($post->cover_image) }}"
                     alt="Couverture actuelle"
                     class="h-32 rounded-lg object-cover mb-2">
                <p class="text-xs text-stone-400 mb-1">Telechargez une nouvelle image pour remplacer.</p>
            @endif
            <input type="file" name="cover_image" accept="image/*"
                   class="text-sm text-stone-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-amber-100 file:text-amber-800 file:font-medium hover:file:bg-amber-200 transition">
        </div>

        {{-- SEO --}}
        <details class="border border-stone-200 rounded-lg p-4">
            <summary class="cursor-pointer text-sm font-medium text-stone-700">Referencement (SEO)</summary>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Titre SEO</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}"
                           class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Meta description</label>
                    <textarea name="meta_description" rows="2"
                              class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </details>

        {{-- Actions --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-6 py-2 rounded-lg text-sm transition">
                {{ isset($post) ? 'Mettre a jour' : 'Creer l\'article' }}
            </button>
            <a href="{{ route('admin.posts.index') }}"
               class="px-6 py-2 rounded-lg border border-stone-300 text-sm hover:bg-stone-100 transition">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
