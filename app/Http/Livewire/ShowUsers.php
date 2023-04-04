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
        return User::whereHas('tag',function($q){
            $q -> where('name','like','%'.$this->search .'%');
        })
        ->orWhere('city', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->orWhere('name', 'like', '%' . $this->search . '%');
    }

    public function getUsersProperty()
    {
        return $this->search ? $this->getSearchResultsProperty()->paginate(20) : User::with('tag')->paginate(20);
    }
    public function render()
    {
        return view('livewire.show-users', [
            'users' => $this->users
        ]);
    }
}