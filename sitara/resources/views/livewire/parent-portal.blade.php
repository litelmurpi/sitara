<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Portal Orang Tua
        </div>
        <h1 class="text-3xl font-bold text-gray-800 font-display">Progress Santri</h1>
    </div>

    <!-- Santri Info Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl font-bold">
                @if($santri->avatar)
                <img src="{{ asset('storage/' . $santri->avatar) }}" alt="{{ $santri->name }}" class="w-full h-full rounded-full object-cover">
                @else
                {{ substr($santri->name, 0, 1) }}
                @endif
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-800">{{ $santri->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $santri->address }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <!-- Rank -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-2 text-amber-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5m14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">#{{ $rank }}</p>
            <p class="text-xs text-gray-500">dari {{ $totalSantri }}</p>
        </div>

        <!-- Total Points -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-2 text-emerald-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($santri->total_points, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500">Total Poin</p>
        </div>

        <!-- Attendance -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center mx-auto mb-2 text-cyan-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $attendances->where('status', 'hadir')->count() }}</p>
            <p class="text-xs text-gray-500">Hadir (14 hari)</p>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Kehadiran</h3>

        @if($attendances->count() > 0)
        <div class="space-y-3">
            @foreach($attendances as $att)
            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                        @if($att->status === 'hadir') bg-emerald-100 text-emerald-600
                        @elseif($att->status === 'izin') bg-blue-100 text-blue-600
                        @elseif($att->status === 'sakit') bg-amber-100 text-amber-600
                        @else bg-red-100 text-red-600 @endif">
                        @if($att->status === 'hadir')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $att->date->translatedFormat('l, d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $att->check_in_time ? 'Check-in: ' . $att->check_in_time : ucfirst($att->status) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold {{ $att->points_gained > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
                        +{{ $att->points_gained }} poin
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Belum ada data kehadiran</p>
        @endif
    </div>

    <!-- Achievements -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pencapaian Terbaru</h3>

        @if($achievements->count() > 0)
        <div class="space-y-3">
            @foreach($achievements as $ach)
            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                        @if($ach->type === 'hafalan') bg-purple-100 text-purple-600
                        @elseif($ach->type === 'adab') bg-pink-100 text-pink-600
                        @else bg-cyan-100 text-cyan-600 @endif">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $ach->description }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($ach->type) }} • {{ $ach->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="text-sm font-bold text-emerald-600">+{{ $ach->points }} poin</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Belum ada pencapaian</p>
        @endif
    </div>

    <!-- Footer Note -->
    <p class="text-center text-sm text-gray-400 mt-8">
        Link ini khusus untuk orang tua {{ $santri->name }}. Jangan bagikan ke orang lain.
    </p>
</div>