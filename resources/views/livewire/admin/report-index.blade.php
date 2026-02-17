<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-display">Laporan</h1>
            <p class="text-gray-500">Rekap data kehadiran, poin, dan keuangan</p>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" wire:model.live="startDate"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" wire:model.live="endDate"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
            </div>
            <a href="{{ route('admin.reports.export', ['type' => $activeTab, 'start' => $startDate, 'end' => $endDate]) }}"
                class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100">
            <nav class="flex">
                <button wire:click="setTab('attendance')"
                    class="px-6 py-4 text-sm font-medium transition-colors {{ $activeTab === 'attendance' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                    Kehadiran
                </button>
                <button wire:click="setTab('points')"
                    class="px-6 py-4 text-sm font-medium transition-colors {{ $activeTab === 'points' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                    Rekap Poin
                </button>
                <button wire:click="setTab('finance')"
                    class="px-6 py-4 text-sm font-medium transition-colors {{ $activeTab === 'finance' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                    Keuangan
                </button>
            </nav>
        </div>

        <!-- Attendance Report -->
        @if($activeTab === 'attendance')
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-sm font-medium text-gray-600">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Santri</th>
                            <th class="px-4 py-3 text-center">Hadir</th>
                            <th class="px-4 py-3 text-center">Telat</th>
                            <th class="px-4 py-3 text-right">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($report as $index => $santri)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $santri->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ $santri->total_hadir ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    {{ $santri->total_telat ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-gray-800">{{ $santri->total_poin_kehadiran ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Points Report -->
        @if($activeTab === 'points')
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-sm font-medium text-gray-600">
                            <th class="px-4 py-3">Rank</th>
                            <th class="px-4 py-3">Nama Santri</th>
                            <th class="px-4 py-3 text-right">Poin Kehadiran</th>
                            <th class="px-4 py-3 text-right">Poin Achievement</th>
                            <th class="px-4 py-3 text-right">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($report as $index => $santri)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                @if($index < 3)
                                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $index === 0 ? 'bg-amber-400 text-white' : ($index === 1 ? 'bg-gray-300 text-gray-700' : 'bg-orange-300 text-white') }}">
                                    {{ $index + 1 }}
                                    </span>
                                    @else
                                    <span class="text-gray-500">{{ $index + 1 }}</span>
                                    @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $santri->name }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ $santri->poin_kehadiran ?? 0 }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ $santri->poin_achievement ?? 0 }}</td>
                            <td class="px-4 py-3 text-right font-bold text-emerald-600">{{ $santri->total_poin ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Finance Report -->
        @if($activeTab === 'finance')
        <div class="p-6 space-y-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-emerald-50 rounded-xl p-4">
                    <p class="text-sm text-emerald-600 mb-1">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-emerald-700">Rp {{ number_format($report['totalIncome'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-rose-50 rounded-xl p-4">
                    <p class="text-sm text-rose-600 mb-1">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-rose-700">Rp {{ number_format($report['totalExpense'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-sm text-blue-600 mb-1">Saldo Periode</p>
                    <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($report['balance'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-sm font-medium text-gray-600">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($report['transactions'] ?? [] as $tx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $tx->date?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $tx->type === 'income' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ ucfirst($tx->category) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $tx->description }}</td>
                            <td class="px-4 py-3 text-right font-medium {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>