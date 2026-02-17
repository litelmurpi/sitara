<div class="space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-display">Galeri Kegiatan</h1>
            <p class="text-gray-500">Dokumentasi kegiatan TPA selama Ramadan</p>
        </div>
        <button wire:click="openModal" class="w-full sm:w-auto px-5 py-2.5 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Foto
        </button>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Cari caption foto..."
                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
        </div>
        <div class="sm:w-48">
            <select wire:model.live="filterCategory" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('message') }}
    </div>
    @endif

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($galleries as $gallery)
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="relative aspect-square overflow-hidden">
                <img
                    src="{{ santri_image($gallery->image_path, 'image') }}"
                    alt="{{ $gallery->caption }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                <!-- Category Badge -->
                <div class="absolute top-3 left-3">
                    <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-xs font-bold text-emerald-700 rounded-lg">
                        {{ ucfirst($gallery->category) }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="delete({{ $gallery->id }})" wire:confirm="Yakin ingin menghapus foto ini?" class="p-2 bg-white/90 backdrop-blur-sm text-rose-500 hover:text-rose-700 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <!-- Caption on Hover -->
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all">
                    <p class="font-medium text-sm line-clamp-2">{{ $gallery->caption }}</p>
                    <p class="text-xs text-gray-300 mt-1">{{ $gallery->date->format('d M Y') }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Belum ada foto</h3>
                <p class="text-gray-500 mb-4">Upload foto pertama untuk memulai galeri.</p>
                <button wire:click="openModal" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-colors">
                    Upload Foto
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
    <div class="mt-8">
        {{ $galleries->links() }}
    </div>
    @endif

    <!-- Upload Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>

        <!-- Modal panel -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <form wire:submit="save">
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $editingId ? 'Edit Foto' : 'Upload Foto Baru' }}
                        </h3>
                        <button type="button" wire:click="closeModal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Photo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                            <div class="relative">
                                @if($photo)
                                <div class="relative rounded-xl overflow-hidden mb-2">
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-48 object-cover">
                                    <button type="button" wire:click="$set('photo', null)" class="absolute top-2 right-2 p-1.5 bg-white/90 text-rose-500 rounded-lg hover:bg-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                @else
                                <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                        <p class="text-xs text-gray-400">PNG, JPG, WEBP (Max. 5MB)</p>
                                    </div>
                                    <input type="file" wire:model="photo" class="hidden" accept="image/*" />
                                </label>
                                @endif
                                <div wire:loading wire:target="photo" class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl">
                                    <svg class="w-8 h-8 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Caption -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <input type="text" wire:model="caption"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50"
                                placeholder="Deskripsi foto">
                            @error('caption') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select wire:model="category" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                                @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" wire:model="date"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                            @error('date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-teal-500/30">
                        {{ $editingId ? 'Simpan Perubahan' : 'Upload' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>