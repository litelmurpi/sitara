<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            @if($selectedSantri)
            <a href="{{ route('admin.santri.show', $selectedSantri) }}" class="hover:text-teal-600 transition-colors">{{ $selectedSantri->name }}</a>
            @else
            <a href="{{ route('admin.santri.index') }}" class="hover:text-teal-600 transition-colors">Daftar Santri</a>
            @endif
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800">Tambah Poin</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Poin Santri</h1>
        <p class="text-sm text-gray-500">Catat pencapaian hafalan, adab, atau partisipasi santri</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('message') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form wire:submit="save" class="p-6 space-y-6">
                    <!-- Santri Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Santri <span class="text-red-500">*</span>
                        </label>

                        @if($selectedSantri)
                        <div class="flex items-center gap-3 bg-teal-50 border border-teal-200 rounded-xl p-3">
                            <div class="w-10 h-10 bg-teal-200 rounded-full flex items-center justify-center overflow-hidden">
                                @if($selectedSantri->avatar)
                                <img src="{{ asset('storage/' . $selectedSantri->avatar) }}" alt="{{ $selectedSantri->name }}" class="w-full h-full object-cover">
                                @else
                                <span class="font-bold text-teal-700">{{ substr($selectedSantri->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $selectedSantri->name }}</p>
                                <p class="text-sm text-gray-500">{{ number_format($selectedSantri->total_points, 0, ',', '.') }} Poin</p>
                            </div>
                            <button type="button" wire:click="clearSantri" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @else
                        <div class="relative">
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="text"
                                placeholder="Cari nama santri..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors bg-gray-50">

                            @if($santris->count() > 0)
                            <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                                @foreach($santris as $santri)
                                <button
                                    type="button"
                                    wire:click="selectSantri({{ $santri->id }})"
                                    class="w-full flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors text-left">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                        @if($santri->avatar)
                                        <img src="{{ asset('storage/' . $santri->avatar) }}" alt="{{ $santri->name }}" class="w-full h-full object-cover">
                                        @else
                                        <span class="text-sm font-bold text-gray-600">{{ substr($santri->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $santri->name }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($santri->total_points, 0, ',', '.') }} Poin</p>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Type Tabs -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Poin <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2 bg-gray-100 rounded-xl p-1">
                            @foreach(['hafalan' => 'Hafalan', 'adab' => 'Adab & Perilaku', 'partisipasi' => 'Partisipasi'] as $key => $label)
                            <button
                                type="button"
                                wire:click="$set('type', '{{ $key }}')"
                                class="flex-1 px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $type === $key ? 'bg-white text-teal-600 shadow-sm' : 'text-gray-600 hover:text-gray-800' }}">
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Presets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Pencapaian
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($presets as $preset)
                            <button
                                type="button"
                                wire:click="selectPreset('{{ $preset['label'] }}', {{ $preset['points'] }})"
                                class="flex items-center justify-between p-3 border rounded-xl transition-colors text-left {{ $description === $preset['label'] ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <span class="text-sm text-gray-700">{{ $preset['label'] }}</span>
                                <span class="text-sm font-semibold {{ $preset['points'] >= 0 ? 'text-teal-600' : 'text-red-600' }}">
                                    {{ $preset['points'] >= 0 ? '+' : '' }}{{ $preset['points'] }}
                                </span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Custom Input -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan <span class="text-red-500">*</span>
                            </label>
                            <input
                                wire:model="description"
                                type="text"
                                id="description"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors bg-gray-50"
                                placeholder="Deskripsi pencapaian">
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="points" class="block text-sm font-medium text-gray-700 mb-2">
                                Poin <span class="text-red-500">*</span>
                            </label>
                            <input
                                wire:model="points"
                                type="number"
                                id="points"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors bg-gray-50"
                                placeholder="Jumlah poin">
                            @error('points') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ $selectedSantri ? route('admin.santri.show', $selectedSantri) : route('admin.santri.index') }}"
                            class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium rounded-xl transition-colors">
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-teal-500/30 flex items-center gap-2"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75 cursor-wait">
                            <span wire:loading.remove>Simpan Poin</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Column -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white sticky top-24">
                <h3 class="text-lg font-semibold mb-4">Preview Poin</h3>

                <div class="bg-white/10 rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm opacity-80">Jenis</span>
                        <span class="font-medium capitalize">{{ $type }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm opacity-80">Keterangan</span>
                        <span class="font-medium text-right max-w-[150px] truncate">{{ $description ?: '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm opacity-80">Poin</span>
                        <span class="text-2xl font-bold">{{ $points >= 0 ? '+' : '' }}{{ $points }}</span>
                    </div>
                </div>

                @if($selectedSantri)
                <div class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center overflow-hidden">
                        @if($selectedSantri->avatar)
                        <img src="{{ asset('storage/' . $selectedSantri->avatar) }}" alt="{{ $selectedSantri->name }}" class="w-full h-full object-cover">
                        @else
                        <span class="font-bold">{{ substr($selectedSantri->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium">{{ $selectedSantri->name }}</p>
                        <p class="text-sm opacity-80">
                            {{ number_format($selectedSantri->total_points, 0, ',', '.') }} →
                            {{ number_format($selectedSantri->total_points + $points, 0, ',', '.') }} Poin
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>