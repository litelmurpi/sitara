<div class="space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.santri.index') }}" class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-800 font-medium">{{ $title }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 font-display">{{ $title }}</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (Form) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 relative overflow-hidden">
                <!-- Decorative background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-bl-[100px] -mr-16 -mt-16 opacity-50"></div>

                <form wire:submit="save" class="relative z-10 space-y-6">
                    <!-- Photo Upload Section -->
                    <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 group">
                        <div class="relative shrink-0">
                            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-lg shadow-emerald-500/10 overflow-hidden bg-gray-100 flex items-center justify-center group-hover:border-emerald-100 transition-all">
                                @if($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                @elseif(isset($santri) && $santri->avatar)
                                <img src="{{ asset('storage/' . $santri->avatar) }}" alt="{{ $santri->name }}" class="w-full h-full object-cover">
                                @else
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @endif
                            </div>
                            <label class="absolute bottom-0 right-0 w-10 h-10 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-colors border-2 border-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                            </label>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-lg font-bold text-gray-800">Foto Profil</h3>
                            <p class="text-sm text-gray-500 mb-2">Format: JPG, PNG (Maks. 2MB)</p>
                            @error('avatar') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Pribadi</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input wire:model="name" type="text" id="name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all outline-none" placeholder="Nama Santri">
                                @error('name') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1">
                                <label for="birth_date" class="text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input wire:model="birth_date" type="date" id="birth_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all outline-none">
                                @error('birth_date') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="address" class="text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea wire:model="address" id="address" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all outline-none resize-none" placeholder="Alamat domisili saat ini"></textarea>
                            @error('address') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Parent Info -->
                    <div class="space-y-4 pt-4">
                        <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Wali</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label for="parent_name" class="text-sm font-medium text-gray-700">Nama Wali <span class="text-rose-500">*</span></label>
                                <input wire:model="parent_name" type="text" id="parent_name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all outline-none" placeholder="Nama Orang Tua">
                                @error('parent_name') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1">
                                <label for="parent_phone" class="text-sm font-medium text-gray-700">No. WhatsApp <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-400 font-medium text-sm">+62</span>
                                    <input wire:model="parent_phone" type="tel" id="parent_phone" class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all outline-none" placeholder="8xxxxxxxxxx">
                                </div>
                                @error('parent_phone') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 flex items-center gap-4 border-t border-gray-100">
                        <button type="submit" class="px-8 py-3 bg-linear-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>{{ $submitLabel }}</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                        <a href="{{ route('admin.santri.index') }}" class="px-6 py-3 text-gray-500 font-medium hover:text-gray-800 hover:bg-gray-50 rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column (Access Info) -->
        <div class="lg:col-span-1 space-y-6">
            @if(isset($santri))
            <!-- QR Code Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-emerald-500 to-teal-500"></div>

                <h3 class="font-bold text-gray-800 mb-1">Kartu Santri</h3>
                <p class="text-xs text-gray-500 mb-6">Scan untuk absensi harian</p>

                <div class="bg-white p-2 rounded-xl border-2 border-dashed border-gray-200 mb-4">
                    <div id="qrcode"></div>
                </div>

                <p class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-lg mb-4 select-all">
                    {{ $santri->qr_token }}
                </p>

                <button onclick="window.print()" class="w-full py-2.5 bg-gray-50 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Kartu
                </button>
            </div>

            <!-- Parent Access -->
            <div class="bg-linear-to-br from-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-10 -mt-10 blur-xl"></div>

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Akses Wali Santri</h3>
                        <p class="text-xs text-slate-400">Portal Orang Tua</p>
                    </div>
                </div>

                <div class="bg-black/20 rounded-xl p-3 mb-4 border border-white/5 backdrop-blur-sm">
                    <p class="text-xs text-slate-400 mb-1">Token Akses</p>
                    <div class="flex items-center justify-between">
                        <code class="font-mono text-emerald-400 font-bold select-all">{{ $santri->parent_access_token }}</code>
                        <button class="text-slate-400 hover:text-white" onclick="navigator.clipboard.writeText('{{ $santri->parent_access_token }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-medium transition-colors shadow-lg shadow-emerald-500/20">
                    Kirim via WhatsApp
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // QR Code Generation
        @if(isset($santri))
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $santri->qr_token }}",
            width: 128,
            height: 128,
            colorDark: "#0f766e", // emerald-700
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        @endif
    });
</script>
@endpush