<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Vite (se estiver usando Laravel Breeze ou Vite manualmente) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-truck-front-fill"></i> {{ config('app.name', 'Frota') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="navbar-nav me-auto">
                <!-- Veículos -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('veiculos.*') ? 'active' : '' }}"
                        href="{{ route('veiculos.index') }}">
                        <i class="bi bi-truck"></i> Veículos
                    </a>
                </li>

                <!-- Motoristas -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('motoristas.*') ? 'active' : '' }}"
                        href="{{ route('motoristas.index') }}">
                        <i class="bi bi-person-vcard"></i> Motoristas
                    </a>
                </li>
            </ul>


            <!-- Usuário / Logout (opcional se usar auth) -->
            @auth
                <span class="navbar-text text-white me-3">Olá, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Sair</button>
                </form>
            @endauth
        </div>
        </div>
    </nav>

    <!-- Page Heading (se existir) -->
    @if (isset($header))
        <header class="bg-white shadow-sm mb-3">
            <div class="container py-4">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="container pb-5">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>