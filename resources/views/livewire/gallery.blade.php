<div class="py-8">
    <!-- Header Section -->
    <div class="py-12 bg-white/50 backdrop-blur-sm overflow-hidden relative text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-amber-50 rounded-full border border-amber-100 text-amber-600 text-xs font-bold mb-6 animate-fade-in-up shadow-sm tracking-wider">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            OUR MOMENTS
        </div>

        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4 font-display tracking-tight leading-tight">
            Galeri <span class="bg-clip-text text-transparent bg-linear-to-r from-emerald-600 to-teal-500">Kegiatan</span>
        </h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Dokumentasi keseruan dan kebersamaan santri TPA SITARA selama bulan suci Ramadan.
        </p>
    </div>

    <!-- Filter Tabs -->
    <div class="max-w-7xl mx-auto px-6 mb-12 relative z-20">
        <div class="bg-white/80 backdrop-blur-md p-1.5 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 max-w-max mx-auto flex flex-wrap justify-center gap-1.5">
            @php
            $filters = [
            'all' => 'Semua',
            'kegiatan' => 'Kegiatan',
            'lomba' => 'Lomba',
            'takjil' => 'Berbagi Takjil',
            'lainnya' => 'Lainnya'
            ];
            @endphp

            @foreach($filters as $key => $label)
            <button
                wire:click="setFilter('{{ $key }}')"
                class="px-5 py-2.5 rounded-xl font-medium transition-all text-sm {{ $filter === $key ? 'bg-linear-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
            @forelse($galleries as $item)
            <div class="break-inside-avoid group relative overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-100">
                <img src="{{ asset('storage/' . $item->image_path) }}"
                    alt="{{ $item->caption }}"
                    class="w-full object-cover transition-transform duration-300 group-hover:scale-105">

                <div class="absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <p class="font-medium line-clamp-2">{{ $item->caption }}</p>
                    <p class="text-sm text-white/70 mt-1">{{ $item->date?->format('d M Y') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-800 mb-2">Belum ada foto</h3>
                <p class="text-slate-500">Galeri foto akan muncul di sini</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    </div>
</div>