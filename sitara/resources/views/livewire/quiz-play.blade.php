<div class="min-h-screen flex flex-col" x-data="quizTimer(@js($quiz->time_per_question))">
    {{-- ===== LOBBY STATE ===== --}}
    @if($state === 'lobby')
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="text-center animate-fadeInUp max-w-2xl">
            {{-- Decorative background --}}
            <div class="fixed inset-0 pointer-events-none">
                <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-violet-600/20 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-teal-500/20 rounded-full blur-[120px]"></div>
            </div>

            <div class="relative z-10">
                {{-- Logo --}}
                <div class="w-20 h-20 bg-linear-to-br from-violet-500 to-purple-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-violet-500/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <p class="text-violet-300 font-medium mb-3 tracking-widest uppercase text-sm">SITARA Quiz</p>
                <h1 class="text-4xl sm:text-6xl font-black text-white mb-4 leading-tight">{{ $quiz->title }}</h1>
                @if($quiz->description)
                <p class="text-xl text-slate-400 mb-8">{{ $quiz->description }}</p>
                @endif

                {{-- Stats --}}
                <div class="flex flex-wrap justify-center gap-6 mb-12">
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white/10">
                        <div class="text-3xl font-black text-white">{{ count($questions) }}</div>
                        <div class="text-sm text-slate-400">Soal</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white/10">
                        <div class="text-3xl font-black text-white">{{ $quiz->time_per_question }}s</div>
                        <div class="text-sm text-slate-400">Per Soal</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white/10">
                        <div class="text-3xl font-black text-white">{{ count($questions) * $quiz->time_per_question }}s</div>
                        <div class="text-sm text-slate-400">Total</div>
                    </div>
                </div>

                @if(count($questions) > 0)
                <button wire:click="start"
                    class="px-12 py-5 bg-linear-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 text-white text-xl font-bold rounded-2xl shadow-2xl shadow-violet-500/40 hover:shadow-violet-500/60 hover:-translate-y-1 transition-all duration-300">
                    Mulai Kuis 🚀
                </button>
                @else
                <p class="text-slate-500">Kuis ini belum memiliki soal.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== PLAYING STATE ===== --}}
    @elseif($state === 'playing')
    @php $current = $questions[$currentIndex] ?? null; @endphp
    @if($current)
    <div class="flex-1 flex flex-col" wire:key="question-{{ $currentIndex }}">
        {{-- Decorative background --}}
        <div class="fixed inset-0 pointer-events-none">
            @php
                $colors = [
                    ['from-rose-600/20', 'from-amber-500/20'],
                    ['from-blue-600/20', 'from-cyan-500/20'],
                    ['from-violet-600/20', 'from-pink-500/20'],
                    ['from-emerald-600/20', 'from-teal-500/20'],
                ];
                $colorSet = $colors[$currentIndex % count($colors)];
            @endphp
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-linear-to-br {{ $colorSet[0] }} to-transparent rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-linear-to-br {{ $colorSet[1] }} to-transparent rounded-full blur-[100px]"></div>
        </div>

        {{-- Top Bar --}}
        <div class="relative z-10 px-6 pt-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/10">
                        <span class="font-bold text-white">{{ $currentIndex + 1 }}</span>
                        <span class="text-slate-400">/{{ count($questions) }}</span>
                    </div>
                    <span class="text-slate-400 text-sm hidden sm:inline">{{ $quiz->title }}</span>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Timer Display --}}
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/10 flex items-center gap-2"
                         :class="timeLeft <= 5 ? 'border-rose-500/50 bg-rose-500/20' : ''">
                        <svg class="w-5 h-5" :class="timeLeft <= 5 ? 'text-rose-400' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-mono font-bold text-lg tabular-nums" :class="timeLeft <= 5 ? 'text-rose-400' : 'text-white'" x-text="timeLeft + 's'"></span>
                    </div>
                </div>
            </div>

            {{-- Timer Bar --}}
            <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-1000 linear"
                     :class="timeLeft <= 5 ? 'bg-rose-500' : 'bg-linear-to-r from-violet-500 to-purple-500'"
                     :style="'width: ' + (timeLeft / {{ $quiz->time_per_question }} * 100) + '%'">
                </div>
            </div>
        </div>

        {{-- Question --}}
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-6 py-8">
            <div class="animate-fadeInUp w-full max-w-4xl">
                {{-- Question Number Badge --}}
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-linear-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-xl shadow-violet-500/30">
                        {{ $currentIndex + 1 }}
                    </div>
                </div>

                {{-- Question Text --}}
                <h2 class="text-2xl sm:text-4xl font-bold text-white text-center mb-10 leading-snug">
                    {{ $current['question'] }}
                </h2>

                {{-- Options Grid --}}
                @php
                    $optionColors = [
                        'a' => ['bg-rose-500', 'bg-rose-600', 'shadow-rose-500/30', 'hover:bg-rose-400'],
                        'b' => ['bg-blue-500', 'bg-blue-600', 'shadow-blue-500/30', 'hover:bg-blue-400'],
                        'c' => ['bg-amber-500', 'bg-amber-600', 'shadow-amber-500/30', 'hover:bg-amber-400'],
                        'd' => ['bg-emerald-500', 'bg-emerald-600', 'shadow-emerald-500/30', 'hover:bg-emerald-400'],
                    ];
                    $optionShapes = [
                        'a' => '◆',
                        'b' => '●',
                        'c' => '▲',
                        'd' => '■',
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                    @php $colors = $optionColors[$opt]; @endphp
                    <div class="option-card {{ $colors[0] }} {{ $colors[3] }} rounded-2xl p-5 sm:p-6 shadow-xl {{ $colors[2] }} cursor-default
                        {{ $showAnswer && $current['correct_answer'] === $opt ? 'ring-4 ring-white scale-105' : '' }}
                        {{ $showAnswer && $current['correct_answer'] !== $opt ? 'opacity-40 scale-95' : '' }}"
                        style="animation: fadeInUp {{ 0.1 + (array_search($opt, ['a','b','c','d']) * 0.1) }}s ease-out">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl text-white/80">{{ $optionShapes[$opt] }}</span>
                            <span class="text-lg sm:text-xl font-bold text-white">{{ $current['option_' . $opt] }}</span>
                            @if($showAnswer && $current['correct_answer'] === $opt)
                            <svg class="w-8 h-8 ml-auto text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bottom Controls --}}
        <div class="relative z-10 px-6 pb-6">
            <div class="flex items-center justify-between">
                <button wire:click="prevQuestion"
                    class="px-5 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-medium transition-all backdrop-blur-sm border border-white/10 {{ $currentIndex === 0 ? 'opacity-30 pointer-events-none' : '' }}">
                    ← Sebelumnya
                </button>

                <div class="flex items-center gap-3">
                    {{-- Pause/Resume Timer --}}
                    <button @click="toggleTimer()"
                        class="p-3 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all backdrop-blur-sm border border-white/10">
                        <svg x-show="running" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                        <svg x-show="!running" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>

                    {{-- Show/Hide Answer --}}
                    <button wire:click="toggleAnswer"
                        class="px-5 py-3 rounded-xl font-medium transition-all backdrop-blur-sm border
                        {{ $showAnswer ? 'bg-emerald-500/20 border-emerald-500/30 text-emerald-300 hover:bg-emerald-500/30' : 'bg-white/10 border-white/10 text-white hover:bg-white/20' }}">
                        {{ $showAnswer ? '🔑 Sembunyikan' : '👁 Lihat Jawaban' }}
                    </button>
                </div>

                <button wire:click="nextQuestion"
                    class="px-5 py-3 bg-linear-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 text-white rounded-xl font-medium transition-all shadow-lg shadow-violet-500/30">
                    {{ $currentIndex === count($questions) - 1 ? 'Selesai ✓' : 'Selanjutnya →' }}
                </button>
            </div>
        </div>
    </div>

    {{-- Alpine Timer Logic --}}
    <div x-init="startTimer()" x-on:question-changed.window="resetTimer()"></div>
    @endif

    {{-- ===== REVEAL STATE (Answer Key) ===== --}}
    @elseif($state === 'reveal')
    <div class="flex-1 overflow-y-auto">
        {{-- Decorative background --}}
        <div class="fixed inset-0 pointer-events-none">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-emerald-600/15 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-teal-500/15 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 py-8">
            {{-- Header --}}
            <div class="text-center mb-10 animate-fadeInUp">
                <div class="w-20 h-20 bg-linear-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-emerald-500/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black text-white mb-3">Kunci Jawaban 🔑</h1>
                <p class="text-xl text-slate-400">{{ $quiz->title }}</p>
            </div>

            {{-- Answer Cards --}}
            <div class="space-y-4">
                @foreach($questions as $index => $q)
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 animate-fadeInUp" style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-10 h-10 bg-linear-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <p class="font-bold text-white text-lg">{{ $q['question'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 ml-14">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                        <div class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm
                            {{ $q['correct_answer'] === $opt ? 'bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold' : 'bg-white/5 border border-white/5 text-slate-400' }}">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                {{ $q['correct_answer'] === $opt ? 'bg-emerald-500 text-white' : 'bg-white/10 text-slate-500' }}">
                                {{ strtoupper($opt) }}
                            </span>
                            {{ $q['option_' . $opt] }}
                            @if($q['correct_answer'] === $opt)
                            <svg class="w-5 h-5 ml-auto text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Bottom Actions --}}
            <div class="flex flex-wrap justify-center gap-4 mt-10 pb-8">
                <button wire:click="backToLobby"
                    class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-medium transition-all backdrop-blur-sm border border-white/10">
                    ← Kembali ke Lobby
                </button>
                <button wire:click="start"
                    class="px-6 py-3 bg-linear-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 text-white rounded-xl font-medium transition-all shadow-lg shadow-violet-500/30">
                    🔄 Mulai Ulang
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

@script
<script>
    Alpine.data('quizTimer', (duration) => ({
        timeLeft: duration,
        running: false,
        interval: null,

        startTimer() {
            this.timeLeft = duration;
            this.running = true;
            this.interval = setInterval(() => {
                if (this.running && this.timeLeft > 0) {
                    this.timeLeft--;
                }
                if (this.timeLeft <= 0) {
                    this.running = false;
                    clearInterval(this.interval);
                    // Auto advance when timer runs out
                    $wire.nextQuestion();
                }
            }, 1000);
        },

        resetTimer() {
            clearInterval(this.interval);
            this.startTimer();
        },

        toggleTimer() {
            this.running = !this.running;
        },

        destroy() {
            clearInterval(this.interval);
        }
    }));
</script>
@endscript
