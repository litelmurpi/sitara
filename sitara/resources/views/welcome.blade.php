<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SITARA') }} - TPA Ramadan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 relative overflow-x-hidden text-slate-800">

    <!-- Ambient Background Blobs -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-teal-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse" style="animation-delay: 2s"></div>
        <div class="absolute top-[20%] right-[20%] w-[30%] h-[30%] bg-amber-300/20 rounded-full blur-[100px] mix-blend-multiply animate-pulse" style="animation-delay: 4s"></div>
    </div>

    <!-- Decoration Pattern -->
    <div class="fixed inset-0 z-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%230f766e\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="w-full px-6 py-4 flex justify-between items-center max-w-7xl mx-auto backdrop-blur-sm sticky top-0 z-50">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-linear-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-500/20">S</div>
                <span class="text-xl font-bold bg-clip-text text-transparent bg-linear-to-r from-emerald-800 to-teal-600">SITARA</span>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/admin') }}" class="px-5 py-2.5 rounded-full bg-white/80 border border-slate-200 text-slate-600 font-medium hover:bg-white hover:shadow-md transition-all">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-linear-to-r from-emerald-600 to-teal-600 text-white font-medium hover:shadow-lg hover:shadow-emerald-500/25 hover:-translate-y-0.5 transition-all">Masuk</a>
                @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="grow flex items-center justify-center px-6 py-12">
            <div class="max-w-7xl w-full grid lg:grid-cols-2 gap-12 items-center">

                <!-- Text Content -->
                <div class="space-y-8 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Ramadan 1447 H
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight text-slate-900">
                        Raih Berkah <br>
                        <span class="bg-clip-text text-transparent bg-linear-to-r from-emerald-600 to-teal-500">TPA Digital</span>
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-lg">
                        Sistem Informasi TPA Ramadan Amanah. Pantau hafalan, kehadiran, dan prestasi santri secara realtime dengan teknologi terkini.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('leaderboard') }}" class="group px-8 py-4 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold hover:border-emerald-500 hover:text-emerald-600 shadow-sm hover:shadow-xl transition-all flex items-center gap-3">
                            <span>Lihat Leaderboard</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <div class="flex items-center gap-4 px-6 py-4">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">A</div>
                                <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-300 flex items-center justify-center text-xs font-bold text-slate-500">B</div>
                                <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-400 flex items-center justify-center text-xs font-bold text-slate-500">C</div>
                            </div>
                            <div class="text-sm">
                                <p class="font-bold text-slate-900">100+ Santri</p>
                                <p class="text-slate-500">Telah Bergabung</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image / Visual -->
                <div class="relative lg:h-[600px] flex items-center justify-center">
                    <div class="relative w-full max-w-md aspect-square">
                        <!-- Glassmorphism Cards Mockup -->
                        <div class="absolute inset-x-8 inset-y-8 bg-linear-to-tr from-emerald-600 to-teal-500 rounded-[3rem] -rotate-6 opacity-20 blur-2xl animate-pulse"></div>

                        <!-- Main Card -->
                        <div class="absolute inset-0 bg-white/60 backdrop-blur-2xl border border-white/50 rounded-[2.5rem] shadow-2xl p-8 flex flex-col justify-between transform transition-transform hover:scale-[1.02] duration-500">
                            <!-- Header Mockup -->
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h3 class="text-2xl font-bold text-slate-800">Assalamu'alaikum</h3>
                                    <p class="text-slate-500">Ahmad Fulan</p>
                                </div>
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-white/50 p-4 rounded-2xl border border-white/60">
                                    <p class="text-sm text-slate-500 mb-1">Total Poin</p>
                                    <p class="text-3xl font-bold text-emerald-600">1,250</p>
                                </div>
                                <div class="bg-white/50 p-4 rounded-2xl border border-white/60">
                                    <p class="text-sm text-slate-500 mb-1">Hafalan</p>
                                    <p class="text-3xl font-bold text-amber-500">5 Juz</p>
                                </div>
                            </div>

                            <!-- QR Code Mockup -->
                            <div class="bg-slate-900 rounded-2xl p-6 text-white text-center relative overflow-hidden group cursor-pointer">
                                <div class="absolute inset-0 bg-linear-to-r from-emerald-500 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-sm opacity-80 mb-2">Scan untuk Absensi</p>
                                    <div class="w-32 h-32 bg-white rounded-lg mx-auto mb-2 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-slate-900" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd" />
                                            <path d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H6a1 1 0 100 2h1z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-mono opacity-60">ID: 8829-1029</p>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute -right-4 top-20 bg-white/80 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/60 animate-bounce" style="animation-duration: 3s">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Ranking</p>
                                    <p class="font-bold text-slate-800">#1 Champion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} SITARA - Remaja Islam Masjid Kemasan.
        </footer>
    </div>
</body>

</html>