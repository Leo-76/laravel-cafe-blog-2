@extends('layouts.app')

@section('title', 'Connexion — La Cafeotheque')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-center mb-8">Connexion</h1>

    <div class="bg-white rounded-xl shadow-sm p-8">

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border border-stone-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-stone-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-stone-300 text-amber-500">
                    Se souvenir de moi
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold py-2 rounded-lg text-sm transition">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-stone-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-amber-600 hover:underline">S'inscrire</a>
        </p>
    </div>
</div>
@endsection
