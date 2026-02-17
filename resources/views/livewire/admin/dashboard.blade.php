<div class="space-y-8 animate-fade-in-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 font-display">Dashboard</h1>
            <div class="flex items-center gap-2 text-slate-500 mt-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition-all font-medium shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export Laporan</span>
            </a>
            <a href="{{ route('admin.scanner') }}" class="flex items-center gap-2 px-5 py-2 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Scan Kehadiran</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Hadir Hari Ini -->
        <div class="relative bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(6,182,212,0.1)] border border-slate-100 overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-cyan-50 rounded-full blur-2xl group-hover:bg-cyan-100 transition-colors duration-500"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center text-cyan-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-500 text-sm font-medium tracking-wide">HADIR HARI INI</span>
                </div>

                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-4xl font-bold text-slate-800">{{ $hadirHariIni }}</span>
                    <span class="text-lg text-slate-400 font-medium">/ {{ $totalSantri }}</span>
                </div>

                <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                    <div class="bg-cyan-500 h-2 rounded-full transition-all duration-1000 ease-out" style="width: {{ $totalSantri > 0 ? ($hadirHariIni / $totalSantri) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-slate-400">{{ $totalSantri > 0 ? round(($hadirHariIni / $totalSantri) * 100) : 0 }}% tingkat kehadiran</p>
            </div>
        </div>

        <!-- Total Poin -->
        <div class="relative bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(245,158,11,0.1)] border border-slate-100 overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-amber-50 rounded-full blur-2xl group-hover:bg-amber-100 transition-colors duration-500"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <span class="text-slate-500 text-sm font-medium tracking-wide">TOTAL POIN</span>
                </div>

                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-4xl font-bold text-slate-800">{{ number_format($totalPoin, 0, ',', '.') }}</span>
                </div>

                <p class="text-sm text-amber-600 font-medium bg-amber-50 inline-block px-2 py-1 rounded-lg">
                    💎 Gamifikasi Aktif
                </p>
            </div>
        </div>

        <!-- Total Santri -->
        <div class="relative bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(16,185,129,0.1)] border border-slate-100 overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors duration-500"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-500 text-sm font-medium tracking-wide">TOTAL SANTRI</span>
                </div>

                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-4xl font-bold text-slate-800">{{ $totalSantri }}</span>
                    <span class="text-lg text-emerald-600 font-medium">+5%</span>
                </div>

                <p class="text-sm text-slate-500">
                    Santri aktif terdaftar.
                </p>
            </div>
        </div>

        <!-- Saldo Kas -->
        <div class="relative bg-white rounded-3xl p-6 shadow-[0_2px_20px_-4px_rgba(59,130,246,0.1)] border border-slate-100 overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors duration-500"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-500 text-sm font-medium tracking-wide">SALDO KAS</span>
                </div>

                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-3xl font-bold text-slate-800">Rp {{ number_format($saldoKas, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center gap-2 text-sm {{ $saldoKas >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $saldoKas >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                    </svg>
                    <span class="font-medium">{{ $saldoKas >= 0 ? 'Keuangan Sehat' : 'Defisit' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities (Left Column - Wider) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                        <div class="mt-1 w-10 h-10 rounded-full flex items-center justify-center shrink-0 
                                @if($activity['type'] === 'attendance') bg-purple-100 text-purple-600
                                @elseif($activity['type'] === 'achievement') bg-amber-100 text-amber-600
                                @else bg-cyan-100 text-cyan-600 @endif">

                            @if($activity['type'] === 'attendance')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @elseif($activity['type'] === 'achievement')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-slate-800">{{ $activity['name'] }}</h4>
                                <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2 py-1 rounded-full group-hover:bg-white transition-colors">
                                    {{ $activity['time']->diffForHumans(null, true) }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">{{ $activity['description'] }}</p>

                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                        @if($activity['status_color'] === 'green') bg-green-50 text-green-700 border-green-100
                                        @elseif($activity['status_color'] === 'teal') bg-teal-50 text-teal-700 border-teal-100
                                        @elseif($activity['status_color'] === 'red') bg-red-50 text-red-700 border-red-100
                                        @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                    {{ $activity['status'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-medium">Belum ada aktivitas terbaru.</p>
                        <p class="text-sm text-slate-400 mt-1">Aktivitas santri akan muncul di sini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions (Right Column) -->
        <div class="space-y-6">
            <div class="bg-linear-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative">
                <!-- Decorative Pattern -->
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');"></div>

                <h3 class="text-lg font-bold mb-4 relative z-10">Menu Cepat</h3>

                <div class="grid grid-cols-2 gap-3 relative z-10">
                    <a href="{{ route('admin.achievement.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-2xl transition-all group text-center">
                        <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Input Poin</span>
                    </a>

                    <a href="{{ route('admin.keuangan.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-2xl transition-all group text-center">
                        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Keuangan</span>
                    </a>

                    <a href="{{ route('admin.santri.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-2xl transition-all group text-center">
                        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Santri Baru</span>
                    </a>

                    <a href="{{ route('admin.materi.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-2xl transition-all group text-center">
                        <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Materi</span>
                    </a>
                </div>
            </div>

            <!-- Quote of the Day -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center">
                <div class="w-12 h-12 {{ $dailyQuote['type'] === 'quran' ? 'bg-emerald-50 text-emerald-500' : 'bg-amber-50 text-amber-500' }} rounded-full flex items-center justify-center mb-4">
                    @if($dailyQuote['type'] === 'quran')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    @else
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 7.55228 14.017 7V4C14.017 3.44772 14.4647 3 15.017 3H19.017C20.6739 3 22.017 4.34315 22.017 6V15C22.017 16.6569 20.6739 18 19.017 18H16.017V21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 7.55228 5.0166 7V4C5.0166 3.44772 5.46432 3 6.0166 3H10.0166C11.6735 3 13.0166 4.34315 13.0166 6V15C13.0166 16.6569 11.6735 18 10.0166 18H7.0166V21H5.0166Z" />
                    </svg>
                    @endif
                </div>
                <p class="text-slate-600 italic mb-3">"{{ $dailyQuote['text'] }}"</p>
                <p class="text-sm font-bold text-slate-800">- {{ $dailyQuote['source'] }}</p>
            </div>
        </div>
    </div>
</div>