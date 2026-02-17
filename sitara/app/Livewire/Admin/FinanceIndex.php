<?php

namespace App\Livewire\Admin;

use App\Models\Finance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.admin')]
#[Title('Keuangan')]
class FinanceIndex extends Component
{
    use WithPagination;

    // Modal state
    public bool $showModal = false;
    public ?int $editingId = null;

    // Filter
    #[Url]
    public string $filterCategory = '';

    // Form fields
    #[Validate('required|in:income,expense')]
    public string $type = 'income';

    #[Validate('required|in:donasi,takjil,hadiah,operasional,lainnya')]
    public string $category = 'donasi';

    #[Validate('required|numeric|min:0')]
    public float $amount = 0;

    #[Validate('required|string|max:255')]
    public string $description = '';

    #[Validate('required|date')]
    public string $date = '';

    public array $categories = [
        'donasi' => 'Donasi',
        'takjil' => 'Takjil',
        'hadiah' => 'Hadiah',
        'operasional' => 'Operasional',
        'lainnya' => 'Lainnya',
    ];

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->reset(['editingId', 'type', 'category', 'amount', 'description']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $finance = Finance::findOrFail($id);

        $this->editingId = $id;
        $this->type = $finance->type;
        $this->category = $finance->category;
        $this->amount = (float) $finance->amount;
        $this->description = $finance->description ?? '';
        $this->date = $finance->date ? $finance->date->format('Y-m-d') : now()->format('Y-m-d');

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'type' => $this->type,
            'category' => $this->category,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
            'created_by' => Auth::id(),
        ];

        if ($this->editingId) {
            Finance::find($this->editingId)->update($data);
            session()->flash('message', 'Transaksi berhasil diperbarui.');
        } else {
            Finance::create($data);
            session()->flash('message', 'Transaksi berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete(int $id)
    {
        Finance::find($id)?->delete();
        session()->flash('message', 'Transaksi berhasil dihapus.');
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $currentBalance = Finance::getCurrentBalance();
        $totalIncome = Finance::income()->sum('amount');
        $totalExpense = Finance::expense()->sum('amount');

        $query = Finance::with('createdBy')->latest('date');

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        $transactions = $query->paginate(10);

        return view('livewire.admin.finance-index', [
            'currentBalance' => $currentBalance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'transactions' => $transactions,
        ]);
    }
}
