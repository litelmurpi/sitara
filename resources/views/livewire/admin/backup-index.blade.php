<div>
    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 font-display tracking-tight">Backup & Restore</h1>
                <p class="text-slate-500 mt-1">Unduh backup data atau pulihkan dari file CSV</p>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('message'))
    <div class="mb-6 px-5 py-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3">
        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-emerald-700 font-medium text-sm">{{ session('message') }}</p>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 px-5 py-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <p class="text-red-700 font-medium text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Data Overview --}}
    <div class="bg-white/70 backdrop-blur-sm rounded-3xl border border-white/60 shadow-sm p-6 mb-8">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-linear-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800 font-display">Ringkasan Data</h2>
                <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ number_format($totalRecords) }}</span> record dari {{ count($tableStats) }} tabel</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @foreach ($tableStats as $stat)
            <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all duration-300">
                <div class="text-2xl mb-2">{{ $stat['icon'] }}</div>
                <div class="text-2xl font-extrabold text-slate-800 font-display">{{ number_format($stat['count']) }}</div>
                <div class="text-xs text-slate-500 font-medium mt-0.5">{{ $stat['name'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Export & Import Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Export Card --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl border border-white/60 shadow-sm p-6 flex flex-col">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-linear-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800 font-display">Download Backup</h2>
            </div>

            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                Unduh seluruh data dalam format <span class="font-semibold text-slate-600">file ZIP</span> berisi CSV per tabel.
                File CSV bisa dibuka di Excel / Google Sheets.
            </p>

            <div class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-100 mb-6">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs text-emerald-700 leading-relaxed">
                        File backup berisi <strong>{{ count($tableStats) }} file CSV</strong> untuk setiap tabel.
                        Extract ZIP lalu gunakan file CSV-nya untuk import.
                    </p>
                </div>
            </div>

            <div class="mt-auto">
                <a href="{{ route('admin.backup.export') }}"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-2xl font-semibold text-sm hover:from-emerald-700 hover:to-teal-700 active:scale-[0.98] transition-all duration-200 shadow-lg shadow-emerald-500/25">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Backup (.zip)
                </a>
            </div>
        </div>

        {{-- Import Card --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl border border-white/60 shadow-sm p-6 flex flex-col">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-linear-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800 font-display">Import dari CSV</h2>
            </div>

            <p class="text-sm text-slate-500 mb-4 leading-relaxed">
                Pilih tabel dan upload file <span class="font-semibold text-slate-600">CSV</span> untuk memulihkan data.
            </p>

            {{-- Warning --}}
            <div class="bg-amber-50/50 rounded-2xl p-4 border border-amber-100 mb-5">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        <strong>Perhatian!</strong> Data lama pada tabel yang dipilih akan <strong>dihapus</strong> dan diganti data dari file CSV.
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.backup.import') }}" method="POST" enctype="multipart/form-data"
                x-data="{ fileName: '', tableName: '', showConfirm: false, importing: false }"
                @submit="importing = true"
                class="flex flex-col flex-1">
                @csrf

                {{-- Table Selector --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Tabel</label>
                    <select name="table_name" x-model="tableName"
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm text-slate-700 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition-all">
                        <option value="">-- Pilih tabel --</option>
                        @foreach (\App\Http\Controllers\BackupController::getTableLabels() as $key => $label)
                        <option value="{{ $key }}">{{ $label }} ({{ $key }}.csv)</option>
                        @endforeach
                    </select>
                    @error('table_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File Upload --}}
                <div class="mb-4 flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">File CSV</label>
                    <label
                        class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:border-amber-400 hover:bg-amber-50/30 transition-all duration-300"
                        :class="fileName ? 'border-amber-400 bg-amber-50/30' : ''">
                        <div class="flex flex-col items-center justify-center py-3">
                            <template x-if="!fileName">
                                <div class="text-center">
                                    <svg class="w-7 h-7 mx-auto text-slate-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-sm text-slate-500"><span class="font-semibold text-slate-600">Klik untuk upload</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">File .csv (maks. 50MB)</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="text-center">
                                    <svg class="w-7 h-7 mx-auto text-amber-500 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-semibold text-amber-700" x-text="fileName"></p>
                                    <p class="text-xs text-amber-500 mt-0.5">File siap diimport</p>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="csv_file" accept=".csv" class="hidden"
                            @change="fileName = $event.target.files[0]?.name || ''" />
                    </label>
                    @error('csv_file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Import Button --}}
                <div class="mt-auto">
                    <template x-if="!showConfirm">
                        <button type="button" @click="if(fileName && tableName) showConfirm = true"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl font-semibold text-sm transition-all duration-200"
                            :class="fileName && tableName
                                ? 'bg-linear-to-r from-amber-500 to-orange-500 text-white hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 active:scale-[0.98]'
                                : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                            :disabled="!fileName || !tableName">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Import CSV
                        </button>
                    </template>

                    <template x-if="showConfirm">
                        <div class="space-y-3">
                            <div class="bg-red-50 rounded-2xl p-4 border border-red-200">
                                <p class="text-sm text-red-700 font-medium text-center">⚠️ Data lama pada tabel ini akan diganti!</p>
                                <p class="text-xs text-red-500 text-center mt-1">Tindakan ini tidak bisa dibatalkan</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="showConfirm = false"
                                    class="px-4 py-3 bg-slate-100 text-slate-600 rounded-2xl font-semibold text-sm hover:bg-slate-200 transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    :disabled="importing"
                                    class="px-4 py-3 bg-red-500 text-white rounded-2xl font-semibold text-sm hover:bg-red-600 transition-all duration-200 disabled:opacity-50"
                                    :class="importing ? 'cursor-wait' : ''">
                                    <span x-show="!importing">Ya, Import!</span>
                                    <span x-show="importing" class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </form>
        </div>
    </div>
</div>