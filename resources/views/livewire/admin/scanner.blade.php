<div class="min-h-[calc(100vh-8rem)]" x-data="scannerApp()">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
        <!-- Scanner Area -->
        <div class="lg:col-span-2">
            <div class="bg-gray-900 rounded-2xl overflow-hidden h-full min-h-[500px] relative">
                <!-- Header -->
                <div class="absolute top-0 left-0 right-0 z-10 flex items-center justify-between p-4 bg-gradient-to-b from-gray-900/80 to-transparent">
                    <div class="flex items-center gap-3">
                        <button onclick="history.back()" class="p-2 text-white/80 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-white">Scanner Kehadiran</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="p-2 text-white/80 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- QR Scanner -->
                <div id="qr-reader" class="w-full h-full"></div>

                <!-- Scanner Frame Overlay -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none" x-show="!scanning">
                    <div class="w-64 h-64 border-2 border-teal-400 rounded-2xl relative">
                        <!-- Corner accents -->
                        <div class="absolute -top-1 -left-1 w-8 h-8 border-t-4 border-l-4 border-teal-400 rounded-tl-xl"></div>
                        <div class="absolute -top-1 -right-1 w-8 h-8 border-t-4 border-r-4 border-teal-400 rounded-tr-xl"></div>
                        <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-4 border-l-4 border-teal-400 rounded-bl-xl"></div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-4 border-r-4 border-teal-400 rounded-br-xl"></div>
                    </div>
                </div>

                <!-- Bottom Controls -->
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-gray-900/90 to-transparent">
                    <p class="text-center text-white/80 text-sm mb-4">Arahkan kamera ke QR santri</p>
                    <div class="flex items-center justify-center gap-4">
                        <button @click="toggleFlash()" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </button>
                        <button @click="startScanner()" class="w-16 h-16 bg-teal-500 hover:bg-teal-600 rounded-full flex items-center justify-center shadow-lg shadow-teal-500/50 transition-colors">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h2m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </button>
                        <button @click="switchCamera()" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Success Modal -->
                @if($showSuccess && $scannedSantri)
                <div class="absolute inset-0 flex items-center justify-center bg-black/60 z-20">
                    <div class="bg-gray-800 rounded-2xl p-6 max-w-sm mx-4 text-center" @click.outside="$wire.closeModal()">
                        <div class="w-16 h-16 bg-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">Scan Berhasil!</h3>
                        <p class="text-gray-400 text-sm mb-4">Data santri ditemukan</p>

                        <div class="flex items-center gap-3 bg-gray-700/50 rounded-xl p-3 mb-4">
                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center overflow-hidden">
                                @if($scannedSantri->avatar)
                                <img src="{{ asset('storage/' . $scannedSantri->avatar) }}" alt="{{ $scannedSantri->name }}" class="w-full h-full object-cover">
                                @else
                                <span class="text-lg font-bold text-white">{{ substr($scannedSantri->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-white">{{ $scannedSantri->name }}</p>
                                <p class="text-sm text-teal-400">{{ $attendanceStatus }}</p>
                            </div>
                        </div>

                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-500/20 text-teal-400 rounded-full text-sm font-medium mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            +{{ $pointsGained }} Poin
                        </div>

                        <button wire:click="closeModal" class="w-full py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors">
                            Scan Lagi
                        </button>
                    </div>
                </div>
                @endif

                <!-- Error Modal -->
                @if($showError)
                <div class="absolute inset-0 flex items-center justify-center bg-black/60 z-20">
                    <div class="bg-gray-800 rounded-2xl p-6 max-w-sm mx-4 text-center" @click.outside="$wire.closeModal()">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Gagal!</h3>
                        <p class="text-gray-400 text-sm mb-4">{{ $errorMessage }}</p>

                        <button wire:click="closeModal" class="w-full py-3 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-xl transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Recent Scans -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-2xl overflow-hidden h-full">
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-white">Terakhir di-scan</h3>
                            <p class="text-sm text-gray-400">Sesi kehadiran hari ini</p>
                        </div>
                        <span class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ $todayCount }}
                        </span>
                    </div>
                </div>

                <div class="divide-y divide-gray-700 max-h-[400px] overflow-y-auto">
                    @forelse($todayAttendances as $attendance)
                    <div class="flex items-center gap-3 p-4 hover:bg-gray-700/50 transition-colors">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center overflow-hidden">
                            @if($attendance->santri->avatar)
                            <img src="{{ asset('storage/' . $attendance->santri->avatar) }}" alt="{{ $attendance->santri->name }}" class="w-full h-full object-cover">
                            @else
                            <span class="text-sm font-bold text-white">{{ substr($attendance->santri->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-white truncate">{{ $attendance->santri->name }}</p>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>Kelas</span>
                                <span class="px-1.5 py-0.5 bg-teal-500/20 text-teal-400 rounded text-xs">+{{ $attendance->points_gained }} Poin</span>
                            </div>
                        </div>
                        <span class="text-sm text-gray-400">
                            {{ $attendance->check_in_time ? Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '-' }}
                        </span>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-400 text-sm">Belum ada yang scan hari ini</p>
                    </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 py-2 text-gray-400 hover:text-white transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Lihat Semua Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function scannerApp() {
        return {
            scanner: null,
            scanning: false,

            init() {
                this.startScanner();
            },

            startScanner() {
                if (this.scanner) {
                    this.scanner.stop();
                }

                this.scanner = new Html5Qrcode("qr-reader");

                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0
                };

                this.scanner.start({
                        facingMode: "environment"
                    },
                    config,
                    (decodedText) => {
                        // Stop scanner temporarily
                        this.scanner.pause();

                        // Process QR code via Livewire
                        @this.processQrCode(decodedText);

                        // Resume after 2 seconds
                        setTimeout(() => {
                            if (this.scanner) {
                                this.scanner.resume();
                            }
                        }, 2000);
                    },
                    (errorMessage) => {
                        // Ignore errors (no QR found in frame)
                    }
                ).catch((err) => {
                    console.error("Scanner error:", err);
                });

                this.scanning = true;
            },

            stopScanner() {
                if (this.scanner) {
                    this.scanner.stop();
                    this.scanning = false;
                }
            },

            switchCamera() {
                // Toggle between front and back camera
                if (this.scanner) {
                    this.scanner.stop().then(() => {
                        this.startScanner();
                    });
                }
            },

            toggleFlash() {
                // Flash toggle (if supported)
                console.log('Flash toggle not implemented');
            }
        }
    }
</script>
@endpush