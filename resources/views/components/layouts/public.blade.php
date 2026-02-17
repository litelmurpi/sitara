<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SITARA' }} - Sistem Informasi TPA Ramadan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-display {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 relative overflow-x-hidden text-slate-800">

    <!-- Ambient Background Blobs -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-emerald-400/15 rounded-full blur-[120px] mix-blend-multiply animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-teal-400/15 rounded-full blur-[120px] mix-blend-multiply animate-blob animate-delay-2000"></div>
        <div class="absolute top-[20%] right-[20%] w-[40%] h-[40%] bg-cyan-400/15 rounded-full blur-[120px] mix-blend-multiply animate-blob animate-delay-4000 hidden md:block"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="w-full px-6 py-4 backdrop-blur-md bg-white/70 border-b border-slate-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-linear-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-500/20">S</div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-linear-to-r from-emerald-800 to-teal-600">SITARA</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('leaderboard') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('leaderboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Leaderboard
                    </a>
                    <a href="{{ route('jadwal') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('jadwal') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Jadwal
                    </a>
                    <a href="{{ route('galeri') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('galeri') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Galeri
                    </a>
                    <a href="{{ route('keuangan') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('keuangan') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Keuangan
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                    <a href="{{ url('/admin') }}" class="px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 hover:shadow transition-all">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-linear-to-r from-emerald-600 to-teal-600 text-white font-medium hover:shadow-lg hover:shadow-emerald-500/25 hover:-translate-y-0.5 transition-all">Masuk</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 text-slate-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-slate-100 pt-4">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('leaderboard') }}" class="px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('leaderboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Leaderboard
                    </a>
                    <a href="{{ route('jadwal') }}" class="px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('jadwal') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Jadwal
                    </a>
                    <a href="{{ route('galeri') }}" class="px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('galeri') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Galeri
                    </a>
                    <a href="{{ route('keuangan') }}" class="px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('keuangan') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        Keuangan
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-linear-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">S</div>
                        <span class="font-bold text-slate-800">SITARA</span>
                        <span class="text-slate-400">•</span>
                        <span class="text-slate-500 text-sm">Ramadan 1447 H</span>
                    </div>

                    <div class="flex items-center gap-6 text-sm text-slate-500">
                        <a href="{{ route('leaderboard') }}" class="hover:text-emerald-600 transition-colors">Leaderboard</a>
                        <a href="{{ route('jadwal') }}" class="hover:text-emerald-600 transition-colors">Jadwal</a>
                        <a href="{{ route('galeri') }}" class="hover:text-emerald-600 transition-colors">Galeri</a>
                        <a href="{{ route('keuangan') }}" class="hover:text-emerald-600 transition-colors">Keuangan</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>