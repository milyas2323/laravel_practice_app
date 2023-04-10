<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class Employees extends Component
{
    use WithPagination;

    public $search;
    public $sortBy   = 'id';
    public $sortAsc  = true;
    public $deleteId = '';

    public function render()
    {
        return view('livewire.employees', [
            'employees' => Employee::when($this->search, function($query){
                return $query->where(function ($query){
                    $query->where('name','like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')->paginate(10)
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if($field == $this->sortBy){

            $this->sortAsc = !$this->sortAsc;
        }

        $this->sortBy = $field;
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Employee::find($this->deleteId)->delete();
    }
}

//where('name','like', $this->search)->orwhere('email', 'like', $this->search);
