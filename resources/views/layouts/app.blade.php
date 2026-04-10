<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Le blog du café : origines, méthodes de préparation, dégustation et culture café.')">
    <title>@yield('title', config('app.name', 'Cafe Blog'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased">

    {{-- Navigation --}}
    <header class="bg-stone-900 text-stone-100 shadow-lg">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide hover:text-amber-400 transition">
                La Cafeotheque
            </a>
            <nav class="flex items-center gap-6 text-sm">
                <a href="{{ route('posts.index') }}" class="hover:text-amber-400 transition">Articles</a>
                @auth
                    <a href="{{ route('admin.posts.index') }}" class="hover:text-amber-400 transition">Administration</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-amber-400 transition">Deconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-amber-400 transition">Connexion</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main content --}}
    <main class="max-w-6xl mx-auto px-4 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-stone-900 text-stone-400 text-sm text-center py-6 mt-16">
        <p>&copy; {{ date('Y') }} La Cafeotheque — Un blog sur le café</p>
    </footer>

</body>
</html>
