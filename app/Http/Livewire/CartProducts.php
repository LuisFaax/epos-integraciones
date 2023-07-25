<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class CartProducts extends Component
{
    public $search;
    //use WithPagination;



    protected $listeners = [
        'refresh' => '$refresh',
        'categorySelected'
    ];

    function categorySelected($categoryId)
    {
        $this->search = "*$categoryId";
    }



    public function render()
    {
        return view('livewire.cart-products', [
            'products' => $this->loadProducts()
        ]);
    }

    function loadProducts()
    {
        if (substr($this->search, 0, 1) == '*') {

            $texto2Search = substr($this->search, 1);
            $this->search = null;

            //search by category name
            if (!empty($texto2Search) && !is_numeric($texto2Search)) {
                return  Product::whereHas('categories', function ($query) use ($texto2Search) {
                    $query->where('name', 'like', "%{$texto2Search}%");
                })->get()->take(9);
            }

            // search by category_id
            if (!empty($texto2Search) && is_numeric($texto2Search)) {
                return Product::whereHas('categories', function ($query) use ($texto2Search) {
                    $query->where('categories.id', $texto2Search);
                })->get()->take(9);
            }
        } else {
            $texto2Search = $this->search;
            $this->search = null;

            if (!empty($texto2Search) && !is_numeric($texto2Search)) {
                return Product::where('name', 'like', "%{$texto2Search}%")
                    ->get()->take(9);
            }


            if (!empty($texto2Search) && is_numeric($texto2Search)) {
                return Product::where('sku', $texto2Search)->get()->take(9);
            }
        }

        return Product::with('images')->orderBy('name', 'asc')->get()->take(9);
    }
}
