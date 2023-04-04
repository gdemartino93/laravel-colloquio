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


    protected $users;

    public function updatingSearch()
    {
        if ($this->search) {
            $this->users = User::whereHas('tag', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('city', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->paginate(20);
        } else {
            $this->mount();
        }
    }

    public function mount()
    {
        $this->users = User::with('tag')->paginate(20);
    }
    public function render()
    {
        $this->updatingSearch();
        return view('livewire.show-users', [
            'users' => $this->users
        ]);
    }
}