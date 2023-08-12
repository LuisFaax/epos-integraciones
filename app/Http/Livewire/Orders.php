<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Orders extends Component
{
    use WithPagination;
    public $order;
    public $taxRate = 0.16;
    public $taxCart = 0, $itemsCart, $subtotalCart = 0, $totalCart = 0;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->order = Session::get('order', new Collection);
    }

    protected $listeners = [
        'refresh' => '$refresh',
        'addProductFromSearch'
    ];

    function addProductFromSearch($productArray, $qty, $price)
    {

        $product = (new Product)->newFromBuilder($productArray);
        $product['price'] = $price;

        dd($product);

        $this->addProduct($product, $qty = 1, $price = 0);
    }

    public function render()
    {
        return view('livewire.orders.orders');
    }
}
