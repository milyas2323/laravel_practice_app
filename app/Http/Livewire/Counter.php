<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count =1;

    public function increament()
    {
        $this->count++;
    }

    public function decreament()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
