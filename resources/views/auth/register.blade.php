@extends('layouts.app')

@section('title', 'Inscription — La Cafeotheque')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-center mb-8">Creer un compte</h1>

    <div class="bg-white rounded-xl shadow-sm p-8">

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold py-2 rounded-lg text-sm transition">
                Creer mon compte
            </button>
        </form>

        <p class="text-center text-sm text-stone-500 mt-6">
            Deja inscrit ?
            <a href="{{ route('login') }}" class="text-amber-600 hover:underline">Se connecter</a>
        </p>
    </div>
</div>
@endsection
