<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;


class CartView extends Component
{

    protected $listeners = ['refresh' => '$refresh'];


    public function render()
    {


        //validamos que exista la sesion
        if (session()->has('cart')) {
            //obtenemos el carrito
            $cart = session('cart');
            // ordenar los items del carrito mediante nombre de forma asc
            $cartInfo = $cart->sortBy(['name', ['name', 'asc']]);
        } else {
            $cartInfo = new Collection;
        }



        return view('livewire.cart-view', compact('cartInfo'));
    }
}
