<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;

    public $search, $editing, $records;
    public Supplier $supplier;

    protected $paginationTheme = 'bootstrap';

    protected $rules =    [
        'supplier.name' => "required|min:2|max:50|unique:suppliers,name",
    ];

    public function mount()
    {

        $this->supplier = new Supplier();
        $this->editing = false;
    }


    protected $listeners = [
        'refresh' => '$refresh',
        'search' => 'searching',
        'Destroy'
    ];

    public function searching($searchText)
    {
        $this->search = trim($searchText);
    }

    public function render()
    {
        return view('livewire.suppliers.suppliers', [
            'suppliers' => $this->loadSuppliers()
        ]);
    }


    function loadSuppliers()
    {

        if (!empty($this->search)) {

            $this->resetPage();

            $query = Supplier::where('name', 'like', "%{$this->search}%")->orderBy('name', 'asc')->paginate(2);
        } else {
            $query =  Supplier::orderBy('name', 'asc')->paginate(2);
        }

        $this->records = $query->total();

        return $query;
    }

    public function Add()
    {
        $this->resetValidation();
        $this->resetExcept('supplier');
        $this->supplier = new Supplier();
    }

    public function Edit(Supplier $supplier)
    {
        $this->resetValidation();
        $this->supplier = $supplier;
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->resetValidation();
        $this->supplier = new Supplier();
        $this->editing = false;
    }


    public function Store()
    {
        sleep(1);


        $this->rules['supplier.name'] = $this->supplier->id > 0 ? "required|min:2|max:50|unique:suppliers,name,{$this->supplier->id}" : 'required|min:2|max:50|unique:suppliers,name';

        $this->validate($this->rules);


        $this->supplier->save();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->resetExcept('supplier');
        $this->dispatchBrowserEvent('stop-loader');

        $this->supplier = new Supplier();
    }


    public function Destroy(Supplier $supplier)
    {

        $supplier->delete();

        $this->resetPage();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->dispatchBrowserEvent('stop-loader');
    }
}
