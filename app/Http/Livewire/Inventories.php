<?php

namespace App\Http\Livewire;

use App\Models\Barcode;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Intervention\Image\ImageManagerStatic;

class Inventories extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;
    public $sortBy  = 'id';
    public $sortAsc = true;
    public $confirmingInventoryDeletion = false;
    public $confirmInventoryAdd = false;
    public $inventory;
    public $image;
    public $newimage;
    public $barcode_search;

    protected $rules = [
        'inventory.name'  => 'required|string|min:4',
        'inventory.price'  => '',
        'inventory.description'  => '',
        'inventory.image'  => '',
        'inventory.employee_id'  => 'required',
    ];

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    public function handleFileUpload($imageData)
    {
        $this->newimage = $imageData;
        $this->image    = "";
    }

    public function render()
    {
        if($this->barcode_search){

            $barcode = Barcode::when($this->barcode_search, function($query){
                            return $query->where('code',$this->barcode_search);
                        })->first();

            if($barcode){

                $this->inventory['name']        =  $barcode->name;
                $this->inventory['price']       =  $barcode->price;
                $this->inventory['description'] =  $barcode->description;
            }
        }

        $inventories = Inventory::when($this->search, function($query){
            return $query->where(function ($query){
                $query->where('name','like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')->paginate(10);

        $employees = Employee::all();

        return view('livewire.inventories', compact('inventories', 'employees'));
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

    public function confirmInventoryDeletion($id)
    {
        $this->confirmingInventoryDeletion = $id;
    }

    public function deleteInventory( Inventory $inventory)
    {
        $inventory = Inventory::find($inventory->id);

        if($inventory->image){

            Storage::disk('public')->delete($inventory->image);
        }

        $inventory->delete();
        $this->confirmingInventoryDeletion = false;

        session()->flash('message', 'Inventory Deleted Successfully');
    }

    public function confirmInventoryAdd()
    {
        $this->reset(['inventory']);
        $this->confirmInventoryAdd = true;

        $this->image    = "";
        $this->newimage = "";
    }

    public function confirmInventoryEdit(Inventory $inventory)
    {
        $this->image    = "";
        $this->newimage = "";

        $this->resetErrorBag();
        $this->inventory = $inventory;

        if ($inventory->image){

            $this->image = $inventory->imagePath;
        }

        $this->confirmInventoryAdd = true;
    }

    public function saveInventory()
    {
        $this->validate();

        if(isset($this->inventory->id)){

            $inventory = Inventory::find($this->inventory->id);

            if($this->newimage) {

                if($inventory->image){

                    Storage::disk('public')->delete($inventory->image);
                }

                //Upload New Image
                $upload_image = $this->storeImage();

                $inventory->image = $upload_image;
                $inventory->save();
            }

            $inventory->name        = $this->inventory['name'];
            $inventory->price       = $this->inventory['price'];
            $inventory->description = $this->inventory['description'];
            $inventory->employee_id = $this->inventory['employee_id'];

            if($inventory->inventory_code == ""){

                $inventory_code = rand('106890122', '100000000');

                $generator = new BarcodeGeneratorHTML();
                $barcode   = $generator->getBarcode($inventory_code, $generator::TYPE_STANDARD_2_5);

                $inventory->inventory_code = $inventory_code;
                $inventory->barcode        = $barcode;
            }

            $inventory->save();

            session()->flash('message', 'Inventory Saved Successfully');

        } else {

            $upload_image   = $this->storeImage();
            $inventory_code = rand('106890122', '100000000');

            if($this->barcode_search){

                $barcode = Barcode::when($this->barcode_search, function($query){
                                return $query->where('code',$this->barcode_search);
                            })->first();

                if($barcode){

                    $inventory_code = $barcode->code;
                }
            }

            $generator = new BarcodeGeneratorHTML();
            $barcode   = $generator->getBarcode($inventory_code, $generator::TYPE_STANDARD_2_5);

            $inventory = new Inventory;
            $inventory->name            = $this->inventory['name'];
            $inventory->price           = $this->inventory['price'];
            $inventory->description     = $this->inventory['description'];
            $inventory->employee_id     = $this->inventory['employee_id'];
            $inventory->image           = $upload_image;
            $inventory->inventory_code  = $inventory_code;
            $inventory->barcode         = $barcode;
            $inventory->save();

            session()->flash('message', 'Inventory Added Successfully');
        }

        $this->newimage       ="";
        $this->barcode_search = "";
        $this->confirmInventoryAdd = false;
    }

    public function storeImage()
    {
        if(!$this->newimage) {

            return null;
        }

        $img = ImageManagerStatic::make($this->newimage)->encode('jpg');

        $name = Str::random().'.jpg';

        Storage::disk('public')->put($name, $img);

        return $name;
    }
}
