@extends('layouts.app')

@section('title', 'Administration — Articles')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Gestion des articles</h1>
    <a href="{{ route('admin.posts.create') }}"
       class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-4 py-2 rounded-lg text-sm transition">
        Nouvel article
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-stone-100 text-stone-600 text-left">
            <tr>
                <th class="px-5 py-3 font-semibold">Titre</th>
                <th class="px-5 py-3 font-semibold">Categorie</th>
                <th class="px-5 py-3 font-semibold">Statut</th>
                <th class="px-5 py-3 font-semibold">Date</th>
                <th class="px-5 py-3 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-100">
            @forelse ($posts as $post)
                <tr class="hover:bg-stone-50">
                    <td class="px-5 py-3 font-medium text-stone-800">
                        {{ Str::limit($post->title, 60) }}
                    </td>
                    <td class="px-5 py-3 text-stone-500">
                        {{ $post->category?->name ?? '—' }}
                    </td>
                    <td class="px-5 py-3">
                        @if ($post->isPublished())
                            <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium">Publie</span>
                        @else
                            <span class="inline-block bg-stone-100 text-stone-500 text-xs px-2 py-0.5 rounded-full font-medium">Brouillon</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-stone-500">
                        {{ $post->published_at?->format('d/m/Y') ?? '—' }}
                    </td>
                    <td class="px-5 py-3 flex gap-3">
                        <a href="{{ route('posts.show', $post->slug) }}"
                           class="text-amber-600 hover:underline">Voir</a>
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="text-blue-600 hover:underline">Editer</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Supprimer cet article ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-stone-400">
                        Aucun article pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
