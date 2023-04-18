<?php

namespace App\Http\Livewire;

use App\Models\Barcode;
use Livewire\Component;
use Livewire\WithPagination;
use Picqer\Barcode\BarcodeGeneratorHTML;

class Barcodes extends Component
{
    use WithPagination;

    public $search;
    public $sortBy  = 'id';
    public $sortAsc = true;
    public $confirmingBarcodeDeletion = false;
    public $confirmBarcodeAdd = false;
    public $barcode;

    protected $rules = [
        'barcode.code'  => 'required|string|min:4',
        'barcode.name'  => 'required|string|min:4',
        'barcode.price'  => '',
        'barcode.description'  => '',
    ];

    public function render()
    {

        $barcodes = Barcode::when($this->search, function($query){
            return $query->where(function ($query){
                $query->where('name','like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')->paginate(10);

        return view('livewire.barcodes', compact('barcodes'));
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

    public function confirmBarcodeDeletion($id)
    {
        $this->confirmingBarcodeDeletion = $id;
    }

    public function deleteBarcode( Barcode $barcode)
    {
        $barcode->delete();
        $this->confirmingBarcodeDeletion = false;

        session()->flash('message', 'Barcode Deleted Successfully');
    }

    public function confirmBarcodeAdd()
    {
        $this->reset(['barcode']);
        $this->confirmBarcodeAdd = true;
    }

    public function confirmBarcodeEdit(Barcode $barcode)
    {

        $this->resetErrorBag();
        $this->barcode = $barcode;

        $this->confirmBarcodeAdd = true;
    }

    public function saveBarcode()
    {
        $this->validate();

        if(isset($this->barcode->id)){

            $code = $this->barcode['code'];

            $generator = new BarcodeGeneratorHTML();
            $barcode   = $generator->getBarcode($code, $generator::TYPE_STANDARD_2_5);

            $barcode_data = Barcode::find($this->barcode->id);

            $barcode_data->name        = $this->barcode['name'];
            $barcode_data->description = $this->barcode['description'];
            $barcode_data->price       = $this->barcode['price'];
            $barcode_data->code        = $this->barcode['code'];
            $barcode_data->barcode     = $barcode;
            $barcode_data->save();

            session()->flash('message', 'Barcode Saved Successfully');

        } else {

            $code = $this->barcode['code'];

            $generator = new BarcodeGeneratorHTML();
            $barcode   = $generator->getBarcode($code, $generator::TYPE_STANDARD_2_5);

            Barcode::create([
                'name'        => $this->barcode['name'],
                'description' => $this->barcode['description'],
                'price'       => $this->barcode['price'],
                'code'        => $code,
                'barcode'     => $barcode,
            ]);

            session()->flash('message', 'Barcode Added Successfully');
        }

        $this->confirmBarcodeAdd = false;
    }
}
