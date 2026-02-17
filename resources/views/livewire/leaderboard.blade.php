<div class="py-8">
    <!-- Hero Header -->
    <div class="relative py-8 lg:py-16 text-center px-4">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-amber-50 rounded-full border border-amber-100 text-amber-600 text-xs font-bold mb-4 animate-fade-in-up shadow-sm tracking-wider">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            WEEKLY CHALLENGE
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-800 mb-3 tracking-tight leading-tight">
            Top Pejuang <span class="bg-clip-text text-transparent bg-linear-to-r from-emerald-600 to-teal-500">Al-Qur'an</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-500 max-w-md mx-auto leading-relaxed mb-8">
            Mari berlomba-lomba dalam kebaikan.<br class="hidden sm:block"> Tingkatkan hafalan dan keaktifanmu di TPA!
        </p>
    </div>

    <!-- Podium Section -->
    @if($topThree->count() >= 3)
    <div class="max-w-4xl mx-auto px-4 mb-16">
        <div class="flex items-end justify-center gap-4 sm:gap-8 md:gap-12 h-64 sm:h-80">
            <!-- 2nd Place -->
            <div class="flex flex-col items-center w-1/3 animate-fade-in-up delay-100 z-10">
                <div class="relative mb-4 group cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-full bg-slate-100 border-4 border-slate-200 overflow-hidden shadow-xl transform transition-all duration-300 group-hover:scale-105 group-hover:border-slate-300">
                        @if($topThree[1]->avatar)
                        <img src="{{ asset('storage/' . $topThree[1]->avatar) }}" alt="{{ $topThree[1]->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-500 text-2xl font-bold">
                            {{ substr($topThree[1]->name, 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 right-0 w-8 h-8 bg-slate-500 text-white rounded-full flex items-center justify-center font-bold border-2 border-white shadow-md">2</div>
                </div>
                <div class="text-center mb-2">
                    <p class="font-bold text-slate-800 line-clamp-1 text-sm sm:text-base">{{ $topThree[1]->name }}</p>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">{{ number_format($topThree[1]->total_points, 0, ',', '.') }} pts</p>
                </div>
                <div class="w-full h-24 sm:h-32 bg-linear-to-t from-slate-200 to-slate-100/50 rounded-t-3xl relative border-t border-white/50 shadow-inner backdrop-blur-sm">
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-slate-400 font-bold text-6xl opacity-20 transform scale-y-110">2</div>
                </div>
            </div>

            <!-- 1st Place -->
            <div class="flex flex-col items-center w-1/3 -mt-12 z-20 animate-fade-in-up">
                <div class="relative mb-4 group cursor-pointer">
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 transition-transform duration-300 group-hover:-translate-y-2">
                        <svg class="w-12 h-12 text-amber-400 drop-shadow-lg filter" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5m14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z" />
                        </svg>
                    </div>
                    <div class="w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 rounded-full bg-amber-50 border-4 border-amber-400 overflow-hidden shadow-2xl shadow-amber-500/30 transform transition-all duration-300 group-hover:scale-105 ring-4 ring-amber-400/20 group-hover:ring-amber-400/40">
                        @if($topThree[0]->avatar)
                        <img src="{{ asset('storage/' . $topThree[0]->avatar) }}" alt="{{ $topThree[0]->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-amber-100 text-amber-600 text-3xl font-bold">
                            {{ substr($topThree[0]->name, 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 px-4 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full text-xs font-bold border-2 border-white shadow-lg whitespace-nowrap z-10">
                        CHAMPION
                    </div>
                </div>
                <div class="text-center mb-2 mt-2">
                    <p class="font-bold text-slate-900 text-base sm:text-lg line-clamp-1">{{ $topThree[0]->name }}</p>
                    <p class="text-amber-500 font-bold text-sm sm:text-base">{{ number_format($topThree[0]->total_points, 0, ',', '.') }} pts</p>
                </div>
                <div class="w-full h-32 sm:h-48 bg-linear-to-t from-amber-200 to-amber-100/50 rounded-t-3xl relative border-t border-white/60 shadow-xl shadow-amber-500/10 backdrop-blur-sm overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-px bg-white/80"></div>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-amber-600 font-bold text-7xl opacity-20 transform scale-y-110">1</div>
                    <div class="absolute inset-0 bg-gradient-to-b from-white/30 to-transparent"></div>
                </div>
            </div>

            <!-- 3rd Place -->
            <div class="flex flex-col items-center w-1/3 animate-fade-in-up delay-200 z-10">
                <div class="relative mb-4 group cursor-pointer">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-full bg-orange-50 border-4 border-orange-700/50 overflow-hidden shadow-xl transform transition-all duration-300 group-hover:scale-105 group-hover:border-orange-700">
                        @if($topThree[2]->avatar)
                        <img src="{{ asset('storage/' . $topThree[2]->avatar) }}" alt="{{ $topThree[2]->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-700 text-2xl font-bold">
                            {{ substr($topThree[2]->name, 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 left-0 w-8 h-8 bg-orange-700 text-white rounded-full flex items-center justify-center font-bold border-2 border-white shadow-md">3</div>
                </div>
                <div class="text-center mb-2">
                    <p class="font-bold text-slate-800 line-clamp-1 text-sm sm:text-base">{{ $topThree[2]->name }}</p>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">{{ number_format($topThree[2]->total_points, 0, ',', '.') }} pts</p>
                </div>
                <div class="w-full h-16 sm:h-24 bg-linear-to-t from-orange-200 to-orange-100/50 rounded-t-3xl relative border-t border-white/50 shadow-inner backdrop-blur-sm">
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-orange-800 font-bold text-6xl opacity-10 transform scale-y-110">3</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Lists Section -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 pb-20">
        <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white/60 p-6 sm:p-8">

            <!-- Search Bar -->
            <div class="relative mb-8 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-500">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Cari nama santri..."
                    class="w-full pl-12 pr-4 py-4 bg-white/80 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all shadow-sm">
            </div>

            <!-- List -->
            <div class="space-y-3">
                @forelse($leaderboard as $santri)
                <div class="bg-white rounded-2xl p-4 flex items-center gap-4 hover:bg-emerald-50/30 border border-slate-100 hover:border-emerald-100 transition-all duration-300 hover:scale-[1.01] hover:shadow-lg hover:shadow-emerald-500/5 group">
                    <div class="w-8 text-center font-bold text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <span class="{{ $santri->rank <= 3 ? 'text-amber-500 text-lg' : '' }}">#{{ $santri->rank }}</span>
                    </div>

                    <div class="relative w-12 h-12 shrink-0">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden border-2 border-slate-100 group-hover:border-emerald-200 transition-colors shadow-sm">
                            @if($santri->avatar)
                            <img src="{{ asset('storage/' . $santri->avatar) }}" alt="{{ $santri->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-500 font-bold">
                                {{ substr($santri->name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                        @if($santri->rank <= 3)
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center text-white text-[10px] border-2 border-white shadow-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6-4.8-6 4.8 2.4-7.2-6-4.8h7.6z" />
                            </svg>
                    </div>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-slate-800 truncate group-hover:text-emerald-700 transition-colors text-base">{{ $santri->name }}</h3>
                    <p class="text-xs text-slate-400 truncate font-medium">Pejuang Subuh</p>
                </div>

                <div class="text-right">
                    <p class="font-bold text-emerald-600 text-lg tabular-nums">{{ number_format($santri->total_points, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Points</p>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-800">Santri tidak ditemukan</h3>
                <p class="text-slate-500">Coba cari dengan kata kunci lain.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $leaderboard->links() }}
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-400 font-medium">Menampilkan {{ $leaderboard->count() }} dari {{ $totalSantri }} santri terbaik</p>
        </div>
    </div>
</div>