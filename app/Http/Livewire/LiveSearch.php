<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class LiveSearch extends Component
{
    use WithPagination;

    public $query, $products, $selectedProduct, $price, $quantity;


    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->products = [];
        $this->selectedProduct = null;
    }

    protected $listeners = ['refresh' => '$refresh'];

    function updatedQuery()
    {
        $this->products = Product::where('name', 'like', "%{$this->query}%")->orderBy('name')->get()->take(5);
    }


    function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->query = $this->selectedProduct->name;

        $this->dispatchBrowserEvent('set-placeholder-ref-price', [
            'value' => ($this->selectedProduct->price2 > 0 && $this->selectedProduct->price2 < $this->selectedProduct->price
                ? $this->selectedProduct->price2 : $this->selectedProduct->price)
        ]);

        $this->products = [];
    }



    function addSelectedProduct()
    {
        if ($this->selectedProduct == null) {
            $this->dispatchBrowserEvent('noty', ['msg' => 'SELECCIONA EL PRODUCTO']);
            return;
        }

        $this->emit('addProductFromSearch', $this->selectedProduct, $this->quantity ?? 1, intval($this->price));

        $this->resetExcept('products');

        $this->dispatchBrowserEvent('addProductFromSearch');
    }

    public function render()
    {
        return view('livewire.live-search');
    }
}
