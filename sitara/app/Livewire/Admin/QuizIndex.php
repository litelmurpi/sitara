<?php

namespace App\Livewire\Admin;

use App\Models\Quiz;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Kuis')]
class QuizIndex extends Component
{
    use WithPagination;

    // Modal state
    public bool $showModal = false;
    public ?int $editingId = null;

    // Form fields
    public string $title = '';
    public string $description = '';
    public string $date = '';
    public int $time_per_question = 30;

    // Search
    public string $search = '';

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['editingId', 'title', 'description']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->time_per_question = 30;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $quiz = Quiz::find($id);
        if ($quiz) {
            $this->editingId = $id;
            $this->title = $quiz->title;
            $this->description = $quiz->description ?? '';
            $this->date = $quiz->date ? $quiz->date->format('Y-m-d') : Carbon::today()->format('Y-m-d');
            $this->time_per_question = $quiz->time_per_question;
            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time_per_question' => 'required|integer|min:5|max:300',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'time_per_question' => $this->time_per_question,
        ];

        if ($this->editingId) {
            Quiz::find($this->editingId)->update($data);
            session()->flash('message', 'Kuis berhasil diperbarui.');
        } else {
            $data['created_by'] = Auth::id();
            Quiz::create($data);
            session()->flash('message', 'Kuis berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function toggleActive(int $id)
    {
        $quiz = Quiz::find($id);
        if ($quiz) {
            $quiz->update(['is_active' => !$quiz->is_active]);
        }
    }

    public function delete(int $id)
    {
        Quiz::find($id)?->delete();
        session()->flash('message', 'Kuis berhasil dihapus.');
    }

    public function render()
    {
        $query = Quiz::withCount('questions')->latest('date');

        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        $quizzes = $query->paginate(10);

        return view('livewire.admin.quiz-index', [
            'quizzes' => $quizzes,
        ]);
    }
}
