<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - SITARA Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
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

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50" x-data="{ sidebarOpen: false }">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-400/10 rounded-full blur-[100px] mix-blend-multiply animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-teal-400/10 rounded-full blur-[100px] mix-blend-multiply animate-blob animate-delay-2000"></div>
    </div>

    <div class="min-h-screen flex relative z-10">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 transform transition-transform duration-300 lg:translate-x-0 lg:sticky lg:top-4 lg:inset-y-auto lg:h-[calc(100vh-2rem)] lg:m-4 lg:rounded-[2rem] bg-white/80 backdrop-blur-xl border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] lg:flex lg:flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo Section -->
            <div class="flex items-center gap-3 px-8 py-8">
                <div class="w-12 h-12 bg-linear-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <span class="text-white font-bold text-xl font-display">S</span>
                </div>
                <div>
                    <h1 class="font-bold text-slate-800 font-display text-lg tracking-tight">SITARA Admin</h1>
                    <p class="text-xs text-slate-500 font-medium tracking-wide">TPA Management</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto py-4 scrollbar-hide">
                <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-2">Menu Utama</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.dashboard') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    Dashboard
                </a>

                <a href="{{ route('admin.santri.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.santri.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.santri.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    Data Santri
                </a>

                <a href="{{ route('admin.keuangan.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.keuangan.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.keuangan.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Keuangan
                </a>

                <a href="{{ route('admin.materi.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.materi.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.materi.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    Materi
                </a>

                <a href="{{ route('admin.quiz.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.quiz.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.quiz.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Kuis
                </a>

                <a href="{{ route('admin.gallery.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.gallery.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.gallery.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    Galeri
                </a>

                <a href="{{ route('admin.scanner') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.scanner') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.scanner') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h2m12 0h2M4 8h2m0 8H4m16-4h2M6 20h2M8 8H6m12 0h2m-6 0h2M8 16h2m8 0h2" />
                        </svg>
                    </div>
                    Scanner
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.reports.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Laporan
                </a>

                <div class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-8">System</div>

                <a href="{{ route('admin.settings.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.settings.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Pengaturan TPA
                </a>

                <a href="{{ route('admin.backup.index') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.backup.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.backup.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    Backup & Restore
                </a>

                <a href="{{ route('admin.profile.edit') }}"
                    class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.profile.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100' : 'text-slate-500 hover:bg-white hover:text-slate-800 hover:shadow-sm' }}">
                    <div class="{{ request()->routeIs('admin.profile.*') ? 'text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    Profil Saya
                </a>
            </nav>

            <!-- User Profile (Glass Card) -->
            <div class="p-4 mt-auto">
                <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-linear-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate font-display">{{ auth()->user()->name ?? 'Admin TPA' }}</p>
                        <p class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Online
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"></div>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-0 flex flex-col min-h-screen">
            <!-- Top Bar Mobile -->
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 lg:hidden border-b border-slate-100">
                <div class="flex items-center justify-between px-4 py-4">
                    <button @click="sidebarOpen = true" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="font-bold text-slate-800">{{ $header ?? 'Dashboard' }}</span>
                    <div class="w-10"></div> <!-- Spacer for balance -->
                </div>
            </header>

            <!-- Desktop Header (Minimal) / Page Content Wrapper -->
            <div class="flex-1 p-4 lg:p-8 lg:overflow-y-auto">
                <!-- Desktop Page Title Area (Optional, consistent with dashboard design) -->
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-auto py-6 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} SITARA - TPA Ramadan
            </footer>
        </main>
    </div>

    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    @stack('scripts')
</body>

</html>