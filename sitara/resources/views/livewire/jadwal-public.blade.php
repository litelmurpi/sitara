<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-amber-50 rounded-full border border-amber-100 text-amber-600 text-xs font-bold mb-4">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            WEEKLY CHALLENGE
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3 font-display">
            Jadwal & <span class="text-emerald-600">Materi</span>
        </h1>
        <p class="text-gray-500">Materi pembelajaran harian TPA SITARA</p>
    </div>

    <!-- Date Navigation -->
    <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 mb-8">
        <div class="flex items-center justify-between">
            <button wire:click="previousDay" class="p-3 hover:bg-gray-100 rounded-xl transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div class="text-center">
                <p class="text-sm text-gray-500 mb-1">{{ $selectedDateParsed->translatedFormat('l') }}</p>
                <p class="text-2xl font-bold text-gray-800">{{ $selectedDateParsed->format('d') }}</p>
                <p class="text-sm text-emerald-600 font-medium">{{ $selectedDateParsed->translatedFormat('F Y') }}</p>
            </div>

            <button wire:click="nextDay" class="p-3 hover:bg-gray-100 rounded-xl transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Date Picker -->
        <div class="mt-4 pt-4 border-t border-gray-100">
            <input type="date" wire:model.live="selectedDate"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50 text-center">
        </div>
    </div>

    <!-- Materials List -->
    <div class="space-y-6">
        @forelse($materials as $material)
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
            <!-- Header -->
            <div class="px-6 py-4 bg-linear-to-r from-emerald-500 to-teal-600">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-lg mb-2">
                            Materi #{{ $loop->iteration }}
                        </span>
                        <h3 class="text-xl font-bold text-white">{{ $material->title }}</h3>
                    </div>
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if($material->content)
                <div class="prose prose-gray max-w-none mb-6">
                    {!! nl2br(e($material->content)) !!}
                </div>
                @endif

                @if($material->video_url)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                        Video Pembelajaran
                    </p>
                    <div class="aspect-video rounded-xl overflow-hidden bg-gray-100 shadow-inner">
                        <iframe
                            src="{{ $material->getYoutubeEmbedUrl() }}"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada materi</h3>
            <p class="text-gray-500">Tidak ada materi untuk tanggal {{ $selectedDateParsed->translatedFormat('d F Y') }}.</p>
            <p class="text-sm text-gray-400 mt-2">Gunakan navigasi untuk melihat materi di tanggal lain.</p>
        </div>
        @endforelse
    </div>
</div>