<?php

namespace App\Livewire;

use App\Models\Finance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
#[Title('Laporan Keuangan - SITARA')]
class FinancePublic extends Component
{
    use WithPagination;

    #[Url]
    public string $filterCategory = '';

    public array $categories = [
        'donasi' => 'Donasi',
        'takjil' => 'Takjil',
        'hadiah' => 'Hadiah',
        'operasional' => 'Operasional',
        'lainnya' => 'Lainnya',
    ];

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $currentBalance = Finance::getCurrentBalance();
        $totalIncome = Finance::income()->sum('amount');
        $totalExpense = Finance::expense()->sum('amount');

        $query = Finance::latest('date');

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        $transactions = $query->paginate(15);

        return view('livewire.finance-public', [
            'currentBalance' => $currentBalance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'transactions' => $transactions,
        ]);
    }
}
