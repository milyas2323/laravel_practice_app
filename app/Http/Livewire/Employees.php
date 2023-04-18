<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class Employees extends Component
{
    use WithPagination;

    public $search;
    public $sortBy  = 'id';
    public $sortAsc = true;
    public $confirmingEmployeeDeletion = false;
    public $confirmEmployeeAdd = false;
    public $employee;

    protected $rules = [
        'employee.name'  => 'required|string|min:4',
        'employee.email' => 'required|string',
        'employee.phone' => 'required|numeric',
        'employee.address' => 'required',
    ];

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

    public function confirmEmployeeDeletion($id)
    {
        $this->confirmingEmployeeDeletion = $id;
    }

    public function deleteItem( Employee $employee)
    {
        $employee->delete();
        $this->confirmingEmployeeDeletion = false;

        session()->flash('message', 'Employee Deleted Successfully');
    }

    public function confirmEmployeeAdd()
    {
        $this->reset(['employee']);
        $this->confirmEmployeeAdd = true;
    }

    public function confirmEmployeeEdit(Employee $employee)
    {
        $this->resetErrorBag();
        $this->employee = $employee;
        $this->confirmEmployeeAdd = true;
    }

    public function saveEmployee()
    {
        $this->validate();

        if( isset( $this->employee->id)) {

            $this->employee->save();
            session()->flash('message', 'Employee Saved Successfully');

        } else {

            Employee::create([
                'name'    => $this->employee['name'],
                'email'   => $this->employee['email'],
                'phone'   => $this->employee['phone'],
                'address' => $this->employee['address'],
            ]);
            session()->flash('message', 'Employee Added Successfully');
        }

        $this->confirmEmployeeAdd = false;

    }
}

//where('name','like', $this->search)->orwhere('email', 'like', $this->search);
