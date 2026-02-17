<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('admin.quiz.index') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium flex items-center gap-1 mb-2" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Kuis
            </a>
            <h1 class="text-2xl font-bold text-gray-800 font-display">{{ $quiz->title }}</h1>
            <p class="text-gray-500">{{ $quiz->description ?: 'Kelola soal untuk kuis ini' }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if($questions->count() > 0)
            <a href="{{ route('quiz.play', $quiz) }}" target="_blank" class="px-5 py-2.5 bg-linear-to-r from-violet-600 to-purple-600 text-white rounded-xl font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                Mulai Presentasi
            </a>
            @endif
            <button wire:click="openQuestionModal" class="px-5 py-2.5 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Soal
            </button>
        </div>
    </div>

    <!-- Quiz Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap gap-6 text-sm">
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $quiz->date?->format('d M Y') }}
            </div>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $quiz->time_per_question }} detik / soal
            </div>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ $questions->count() }} soal
            </div>
            <div class="flex items-center gap-2">
                @if($quiz->is_active)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    Aktif
                </span>
                @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                    Non-aktif
                </span>
                @endif
            </div>
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

    <!-- Questions List -->
    <div class="space-y-4">
        @forelse($questions as $index => $q)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-linear-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-sm shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <p class="font-medium text-gray-800">{{ $q->question }}</p>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button wire:click="moveUp({{ $q->id }})" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors {{ $index === 0 ? 'opacity-30 pointer-events-none' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                    <button wire:click="moveDown({{ $q->id }})" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors {{ $index === $questions->count() - 1 ? 'opacity-30 pointer-events-none' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <button wire:click="editQuestion({{ $q->id }})" class="p-1.5 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button wire:click="deleteQuestion({{ $q->id }})" wire:confirm="Yakin ingin menghapus soal ini?" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 ml-13">
                @foreach(['a', 'b', 'c', 'd'] as $opt)
                <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm {{ $q->correct_answer === $opt ? 'bg-emerald-50 border border-emerald-200 text-emerald-800 font-medium' : 'bg-gray-50 border border-gray-100 text-gray-600' }}">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $q->correct_answer === $opt ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        {{ strtoupper($opt) }}
                    </span>
                    {{ $q->{'option_' . $opt} }}
                    @if($q->correct_answer === $opt)
                    <svg class="w-4 h-4 ml-auto text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-1">Belum ada soal</h3>
            <p class="text-gray-500 mb-4">Tambahkan soal pertama untuk kuis ini.</p>
            <button wire:click="openQuestionModal" class="px-5 py-2.5 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all">
                Tambah Soal
            </button>
        </div>
        @endforelse
    </div>

    <!-- Add/Edit Question Modal -->
    @if($showQuestionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeQuestionModal"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <form wire:submit="saveQuestion">
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $editingQuestionId ? 'Edit Soal' : 'Tambah Soal Baru' }}
                        </h3>
                        <button type="button" wire:click="closeQuestionModal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Question -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan</label>
                            <textarea wire:model="question" rows="2"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50 resize-none"
                                placeholder="Tulis pertanyaan..."></textarea>
                            @error('question') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Options -->
                        @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $correct_answer === $key ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-600' }}">{{ $label }}</span>
                                    Opsi {{ $label }}
                                </span>
                            </label>
                            <input type="text" wire:model="option_{{ $key }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50"
                                placeholder="Jawaban {{ $label }}...">
                            @error('option_' . $key) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        @endforeach

                        <!-- Correct Answer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jawaban Benar</label>
                            <div class="flex gap-3">
                                @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                                <label class="flex-1">
                                    <input type="radio" wire:model.live="correct_answer" value="{{ $key }}" class="peer hidden">
                                    <div class="text-center py-3 rounded-xl border-2 cursor-pointer transition-all font-bold peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 border-gray-200 text-gray-500 hover:border-gray-300">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('correct_answer') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="closeQuestionModal" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-xl transition-colors shadow-lg shadow-teal-500/30">
                        {{ $editingQuestionId ? 'Simpan Perubahan' : 'Tambah Soal' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
