<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Profile Card -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Breadcrumb -->
            <div class="px-6 pt-4">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('admin.santri.index') }}" class="hover:text-teal-600 transition-colors">Daftar Santri</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-800">Detail Profil</span>
                </div>
            </div>

            <!-- Avatar & Name -->
            <div class="p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-gray-200 rounded-full flex items-center justify-center overflow-hidden mb-4">
                    @if($santri->avatar)
                    <img src="{{ santri_image($santri->avatar) }}" alt="{{ $santri->name }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-3xl font-bold text-gray-600">{{ substr($santri->name, 0, 1) }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-800">{{ $santri->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">Kelas • Regu Al-Fatih</p>
            </div>

            <!-- Info -->
            <div class="px-6 pb-6 space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Wali Santri</p>
                        <p class="text-sm font-medium text-gray-800">{{ $santri->parent_name }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Alamat</p>
                        <p class="text-sm font-medium text-gray-800">{{ $santri->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Button -->
            <div class="px-6 pb-6">
                <a href="{{ route('admin.santri.edit', $santri) }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>

        <!-- Points Card -->
        <div class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                <span class="text-sm font-medium opacity-90">TOTAL POIN</span>
            </div>
            <div class="text-4xl font-bold mb-2">{{ number_format($stats['total_poin'], 0, ',', '.') }} <span class="text-lg font-normal opacity-90">Poin</span></div>
            <div class="flex items-center justify-between">
                <span class="text-sm opacity-90">Peringkat: {{ $stats['rank'] }} Tertinggi</span>
                @if($stats['rank'] <= 3)
                    <span class="px-2 py-1 bg-white/20 rounded-full text-xs font-medium">Top 5%</span>
                    @endif
            </div>
        </div>

        <!-- QR Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Kartu QR</h3>
            <div class="bg-gray-100 rounded-xl p-4 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-32 h-32 bg-white rounded-lg mx-auto mb-3 flex items-center justify-center"
                        id="qrcode"
                        x-data
                        x-init="
                            new QRCode(document.getElementById('qrcode'), {
                                text: '{{ $santri->qr_token }}',
                                width: 128,
                                height: 128,
                                colorDark : '#0D9488',
                                colorLight : '#ffffff',
                            });
                         ">
                    </div>
                    <p class="text-xs text-gray-500">Token: {{ substr($santri->qr_token, 0, 8) }}...</p>
                </div>
            </div>
            <button
                onclick="window.open('{{ route('admin.santri.card', $santri) }}', '_blank')"
                class="w-full mt-4 flex items-center justify-center gap-2 px-4 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-teal-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Kartu
            </button>
        </div>

        <!-- Parent Portal Link -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <h3 class="font-semibold text-gray-800">Link Portal Orang Tua</h3>
            </div>
            <p class="text-xs text-gray-500 mb-3">Bagikan link ini ke orang tua untuk memantau progress anak</p>
            <div class="flex items-center gap-2">
                <input type="text"
                    id="parentPortalLink"
                    value="{{ route('parent.portal', $santri->parent_access_token) }}"
                    readonly
                    class="flex-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-xs text-gray-600 truncate">
                <button
                    onclick="copyParentLink()"
                    class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Copy
                </button>
            </div>
            <div id="copySuccess" class="hidden mt-2 text-xs text-emerald-600 font-medium">✓ Link berhasil disalin!</div>
        </div>

        <script>
            function copyParentLink() {
                const input = document.getElementById('parentPortalLink');
                input.select();
                input.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(input.value);
                document.getElementById('copySuccess').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('copySuccess').classList.add('hidden');
                }, 2000);
            }
        </script>
    </div>

    <!-- Right Column - Activity History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Poin</h3>
                        <p class="text-sm text-gray-500">Catatan aktivitas dan perolehan poin santri.</p>
                    </div>
                    <a href="{{ route('admin.achievement.create', ['santri_id' => $santri->id]) }}"
                        class="flex items-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-teal-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Poin
                    </a>
                </div>

                <!-- Tab Filters -->
                <div class="flex items-center gap-2 mt-4 overflow-x-auto pb-1">
                    @foreach(['semua' => 'Semua', 'hafalan' => 'Hafalan', 'adab' => 'Adab & Perilaku', 'kehadiran' => 'Kehadiran'] as $key => $label)
                    <button
                        wire:click="$set('tab', '{{ $key }}')"
                        class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors {{ $tab === $key ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Activity List -->
            <div class="divide-y divide-gray-50">
                @forelse($activities as $activity)
                <div class="flex items-start gap-4 p-6 hover:bg-gray-50 transition-colors">
                    <!-- Icon -->
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                            {{ $activity['type'] === 'hafalan' ? 'bg-teal-100 text-teal-600' : '' }}
                            {{ $activity['type'] === 'adab' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $activity['type'] === 'kehadiran' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $activity['type'] === 'partisipasi' ? 'bg-purple-100 text-purple-600' : '' }}
                        ">
                        @if($activity['type'] === 'hafalan')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        @elseif($activity['type'] === 'kehadiran')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-800">{{ $activity['title'] }}</h4>
                        @if($activity['description'])
                        <p class="text-sm text-gray-500 mt-0.5">{{ $activity['description'] }}</p>
                        @endif
                    </div>

                    <!-- Date & Points -->
                    <div class="text-right shrink-0">
                        <p class="text-sm text-gray-500">{{ $activity['date']->format('d M Y') }}</p>
                        <p class="text-sm font-semibold {{ $activity['is_positive'] ? 'text-teal-600' : 'text-red-600' }}">
                            {{ $activity['is_positive'] ? '+' : '' }}{{ $activity['points'] }}
                            <span class="text-xs font-normal text-gray-400">POIN</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">Belum ada aktivitas</h3>
                    <p class="text-gray-500">Riwayat poin akan muncul di sini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush