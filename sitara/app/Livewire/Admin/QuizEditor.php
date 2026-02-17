<?php

namespace App\Livewire\Admin;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Editor Kuis')]
class QuizEditor extends Component
{
    public Quiz $quiz;

    // Question form
    public bool $showQuestionModal = false;
    public ?int $editingQuestionId = null;
    public string $question = '';
    public string $option_a = '';
    public string $option_b = '';
    public string $option_c = '';
    public string $option_d = '';
    public string $correct_answer = 'a';

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function openQuestionModal()
    {
        $this->reset(['editingQuestionId', 'question', 'option_a', 'option_b', 'option_c', 'option_d']);
        $this->correct_answer = 'a';
        $this->showQuestionModal = true;
    }

    public function closeQuestionModal()
    {
        $this->showQuestionModal = false;
        $this->resetErrorBag();
    }

    public function editQuestion(int $id)
    {
        $q = QuizQuestion::find($id);
        if ($q) {
            $this->editingQuestionId = $id;
            $this->question = $q->question;
            $this->option_a = $q->option_a;
            $this->option_b = $q->option_b;
            $this->option_c = $q->option_c;
            $this->option_d = $q->option_d;
            $this->correct_answer = $q->correct_answer;
            $this->showQuestionModal = true;
        }
    }

    public function saveQuestion()
    {
        $this->validate([
            'question' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $data = [
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'correct_answer' => $this->correct_answer,
        ];

        if ($this->editingQuestionId) {
            QuizQuestion::find($this->editingQuestionId)->update($data);
            session()->flash('message', 'Soal berhasil diperbarui.');
        } else {
            $data['quiz_id'] = $this->quiz->id;
            $data['order'] = $this->quiz->questions()->count();
            QuizQuestion::create($data);
            session()->flash('message', 'Soal berhasil ditambahkan.');
        }

        $this->closeQuestionModal();
        $this->quiz->refresh();
    }

    public function deleteQuestion(int $id)
    {
        QuizQuestion::find($id)?->delete();
        $this->quiz->refresh();
        session()->flash('message', 'Soal berhasil dihapus.');
    }

    public function moveUp(int $id)
    {
        $question = QuizQuestion::find($id);
        if ($question && $question->order > 0) {
            $prev = $this->quiz->questions()->where('order', $question->order - 1)->first();
            if ($prev) {
                $prev->update(['order' => $question->order]);
                $question->update(['order' => $question->order - 1]);
            }
        }
        $this->quiz->refresh();
    }

    public function moveDown(int $id)
    {
        $question = QuizQuestion::find($id);
        $maxOrder = $this->quiz->questions()->count() - 1;
        if ($question && $question->order < $maxOrder) {
            $next = $this->quiz->questions()->where('order', $question->order + 1)->first();
            if ($next) {
                $next->update(['order' => $question->order]);
                $question->update(['order' => $question->order + 1]);
            }
        }
        $this->quiz->refresh();
    }

    public function render()
    {
        return view('livewire.admin.quiz-editor', [
            'questions' => $this->quiz->questions()->orderBy('order')->get(),
        ]);
    }
}
