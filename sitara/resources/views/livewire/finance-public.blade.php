<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Hero Header -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100/80 text-emerald-700 rounded-full text-sm font-medium mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            Transparansi Keuangan
        </div>
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4 font-display">
            Laporan <span class="bg-clip-text text-transparent bg-linear-to-r from-emerald-600 to-teal-500">Keuangan</span> TPA
        </h1>
        <p class="text-gray-500 max-w-xl mx-auto">
            Lihat aliran dana donasi dan pengeluaran program TPA secara transparan.
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Balance Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-blue-50 rounded-bl-full -mr-4 -mt-4"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500 mb-1">Saldo Saat Ini</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($currentBalance, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Income Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-emerald-50 rounded-bl-full -mr-4 -mt-4"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pemasukan</p>
                <h3 class="text-2xl font-bold text-emerald-600">+ Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Expense Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-rose-50 rounded-bl-full -mr-4 -mt-4"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-bold text-rose-600">- Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Transaction List Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header with Filter -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Transaksi</h2>
                    <p class="text-sm text-gray-500">{{ $transactions->total() }} catatan transaksi</p>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="flex items-center gap-2 mt-4 overflow-x-auto pb-1">
                <button
                    wire:click="$set('filterCategory', '')"
                    class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors {{ $filterCategory === '' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </button>
                @foreach($categories as $key => $label)
                <button
                    wire:click="$set('filterCategory', '{{ $key }}')"
                    class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-colors {{ $filterCategory === $key ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Transaction List -->
        <div class="divide-y divide-gray-50">
            @forelse($transactions as $transaction)
            <div class="flex items-center justify-between p-4 sm:p-6 hover:bg-gray-50/50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $transaction->type === 'income' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                        @if($transaction->type === 'income')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                        </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $transaction->description }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs text-gray-500">{{ $transaction->date->format('d M Y') }}</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ ucfirst($transaction->category) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Belum ada transaksi</h3>
                <p class="text-gray-500">Data transaksi akan muncul di sini</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>