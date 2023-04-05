<?php
namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public string $search = '';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function getSearchResultsProperty()
    {
        $searchWords = preg_split('/\s+/', $this->search);

        return User::where(function ($q) use ($searchWords) {
                foreach ($searchWords as $word) {
                    $q->where(function ($q) use ($word) {
                        $q->where('name', 'like', '%' . $word . '%');
                    });
                }
            })
            ->orWhere('city', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhereHas('tag', function ($q) use ($searchWords) {
                $q->where(function ($q) use ($searchWords) {
                    foreach ($searchWords as $word) {
                        $q->where('name', 'like', '%' . $word . '%');
                    }
                });
            });
    }  

    public function getUsersProperty()
    {
        return ($this->search ? $this->search_results : User::with('tag'))
			->paginate(20);
    }
    public function render()
    {
        return view('livewire.show-users');
    }
}
