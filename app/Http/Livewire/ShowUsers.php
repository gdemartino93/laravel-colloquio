<?php
namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
			// la ricerca nei tag non funziona come dovrebbe
			// ora seleziona solo i tag che contengono tutte le parole della ricerca al loro interno
			// ma io voglio trovare gli utenti che hanno ciascuno dei tag che cerco
			// prova a digitare "sint vero": non comparirà nessuno ora, anche se esistono utenti
			// con entrambi i tag
            ->orWhereHas('tags', function ($q) use ($searchWords) {
                $q->where(function ($q) use ($searchWords) {
                    foreach ($searchWords as $word) {
                        $q->orWhere('name', 'like', '%' . $word . '%');
                    }
                });
            }, '>=', count($searchWords));
    }

    public function getUsersProperty()
    {
        return ($this->search ? $this->search_results : User::query())
			->with('tags')
			->paginate(20);
    }
    public function render()
    {
        return view('livewire.show-users');
    }
}
