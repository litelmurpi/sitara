<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800 font-display">Pengaturan TPA</h1>
        <p class="text-gray-500">Kelola informasi dan branding TPA</p>
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

    <form wire:submit="save" class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- TPA Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Informasi TPA
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama TPA</label>
                        <input type="text" wire:model="tpa_name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50"
                            placeholder="TPA SITARA">
                        @error('tpa_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea wire:model="tpa_address" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50 resize-none"
                            placeholder="Alamat lengkap TPA"></textarea>
                        @error('tpa_address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" wire:model="tpa_phone"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50"
                            placeholder="08xxxxxxxxxx">
                        @error('tpa_phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Branding -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Branding
                </h2>

                <div class="space-y-6">
                    <!-- Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo TPA</label>
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-200">
                                @if($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($current_logo)
                                <img src="{{ santri_image($current_logo, 'image') }}" class="w-full h-full object-cover">
                                @else
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                            <div class="flex-1 space-y-2">
                                <label class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-center cursor-pointer hover:bg-gray-100 transition-colors">
                                    <span class="text-sm text-gray-600">Pilih Logo</span>
                                    <input type="file" wire:model="logo" class="hidden" accept="image/*">
                                </label>
                                @if($current_logo)
                                <button type="button" wire:click="removeLogo" class="w-full px-4 py-2 text-sm text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors">
                                    Hapus Logo
                                </button>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Format: PNG, JPG, WEBP. Maks. 2MB</p>
                        @error('logo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Tema Utama</label>
                        <div class="flex items-center gap-4">
                            <input type="color" wire:model="primary_color"
                                class="w-16 h-12 rounded-xl cursor-pointer border border-gray-200">
                            <input type="text" wire:model="primary_color"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50 font-mono"
                                placeholder="#059669">
                        </div>
                        <div class="mt-3 flex gap-2">
                            @foreach(['#059669', '#0ea5e9', '#8b5cf6', '#f59e0b', '#ef4444'] as $color)
                            <button type="button" wire:click="$set('primary_color', '{{ $color }}')"
                                class="w-8 h-8 rounded-lg border-2 transition-all {{ $primary_color === $color ? 'ring-2 ring-offset-2 ring-gray-400' : 'border-gray-200' }}"
                                style="background-color: {{ $color }}"></button>
                            @endforeach
                        </div>
                        @error('primary_color') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-linear-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-xl transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>