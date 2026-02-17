<?php

namespace App\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.quiz')]
#[Title('Kuis')]
class QuizPlay extends Component
{
    public Quiz $quiz;
    public array $questions = [];
    public int $currentIndex = 0;
    public string $state = 'lobby'; // lobby, playing, reveal
    public bool $showAnswer = false;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->questions = $quiz->questions()->orderBy('order')->get()->toArray();
    }

    public function start()
    {
        if (count($this->questions) === 0) return;
        $this->currentIndex = 0;
        $this->state = 'playing';
        $this->showAnswer = false;
        $this->dispatch('question-changed');
    }

    public function nextQuestion()
    {
        $this->showAnswer = false;
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
            $this->dispatch('question-changed');
        } else {
            $this->state = 'reveal';
        }
    }

    public function prevQuestion()
    {
        $this->showAnswer = false;
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->dispatch('question-changed');
        }
    }

    public function toggleAnswer()
    {
        $this->showAnswer = !$this->showAnswer;
    }

    public function goToReveal()
    {
        $this->state = 'reveal';
    }

    public function backToLobby()
    {
        $this->state = 'lobby';
        $this->currentIndex = 0;
        $this->showAnswer = false;
    }

    public function render()
    {
        return view('livewire.quiz-play');
    }
}
