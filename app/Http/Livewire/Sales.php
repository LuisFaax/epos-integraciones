<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class Sales extends Component
{
    use WithPagination;
    public Collection $cart;
    public $taxCart = 0, $itemsCart, $subtotalCart = 0, $totalCart = 0;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        if (session()->has('cart')) {
            $this->cart = session('cart');
        } else {
            $this->cart = new Collection;
        }
    }

    protected $listeners = [
        'refresh' => '$refresh',
        'add-product' => 'addProductFromCard',
        'removeItem', 'updateQty',
        'clear-cart' => 'clear'
    ];


    public function render()
    {

        $this->taxCart = round($this->totalIVA());
        $this->itemsCart = $this->totalItems();
        $this->subtotalCart = round($this->subtotalCart() / 1.16);
        $this->totalCart = round($this->totalCart());

        return view('livewire.sales.sales');
    }

    // metodos del carrito

    function removeItem($id)
    {
        $this->cart = $this->cart->reject(function ($product) use ($id) {
            return $product['id'] === $id;
        });

        $this->save();

        $this->emit('refresh');
        $this->dispatchBrowserEvent('noty', ['msg' => 'PRODUCT DELETED']);
    }

    function addProductFromCard(Product $product)
    {
        $this->AddProduct($product);
    }

    function AddProduct($product, $qty = 1)
    {
        // validar si ya existe en el carrito
        if ($this->inCart($product->id)) {
            $this->updateQty(null, $qty, $product->id);
            return; // => con esta línea se agrupan los productos por nombre dentro del carrito
        }

        //agregar al carrito

        // iva méxico 16%
        $iva = 0.16;
        // determinar precio venta con iva
        $salePrice = ($product->price2 > 0 && $product->price2 < $product->price ?  $product->price2 : $product->price);
        //precio unitario sin iva
        $precioUnitarioSinIva = $salePrice / (1 + $iva);
        // subtotal neto
        $subtotalNeto = $precioUnitarioSinIva * intval($qty);
        //monto del iva
        $montoIva = $subtotalNeto * $iva;
        //total con iva
        $totalConIva  = $subtotalNeto + $montoIva;

        $tax  = $montoIva;
        $total = $totalConIva;
        $uid = uniqid() . $product->id;

        $coll = collect(
            [
                'id' => $uid,
                'pid' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price1' => $product->price,
                'price2' => $product->price2,
                'sale_price' => $salePrice,
                'qty' => intval($qty),
                'tax' => $tax,
                'total' => $total,
                'stock' => $product->stock_qty,
                'type' => $product->type,
                'image' => $product->photo,
                'platform_id' => $product->platform_id
            ]
        );
        $itemCart = Arr::add($coll, null, null);
        $this->cart->push($itemCart);
        $this->save();
        $this->emit('refresh');
        $this->dispatchBrowserEvent('noty', ['msg' => 'PRODUCT ADDED TO CART']);
    }


    function save()
    {
        session()->put('cart', $this->cart);
        session()->save();
    }

    function inCart($product_id)
    {
        $mycart = $this->cart;

        $cont = $mycart->where('pid', $product_id)->count();

        return  $cont > 0 ? true : false;
    }

    function updateQty($uid, $cant = 1, $product_id = null)
    {
        if (!is_numeric($cant)) {
            $this->dispatchBrowserEvent('noty-error', ['msg' => 'INVALID QUANTITY VALUE']);
            return;
        }

        $mycart = $this->cart;
        if ($product_id == null) {
            $oldItem = $mycart->where('id', $uid)->first();
        } else {
            $oldItem = $mycart->where('pid', $product_id)->first();
        }


        $newItem  = $oldItem;

        $newItem['qty'] = $product_id == null ? intval($cant) : intval($newItem['qty'] + $cant);

        $values = $this->Calculator($newItem['sale_price'], $newItem['qty']);

        $newItem['tax'] =  $values['iva'];

        $newItem['total'] = round($values['total']);


        //eliminar el item de la coleccion / sesion
        $this->cart  = $this->cart->reject(function ($product) use ($uid, $product_id) {
            return  $product['id'] === $uid || $product['pid'] === $product_id;
        });
        $this->save();

        $this->cart->push(Arr::add($newItem, null, null));
        $this->save();

        $this->emit('refresh');
        $this->dispatchBrowserEvent('noty', ['msg' => 'PRODUCT UPDATED']);
    }


    function Calculator($price, $qty)
    {
        //iva méxico 16%
        $iva = 0.16;
        //determinamos el precio de venta(con iva)
        $salePrice = $price;
        // precio unitario sin iva
        $precioUnitarioSinIva =  $salePrice / (1 + $iva);
        // subtotal neto
        $subtotalNeto =   $precioUnitarioSinIva * intval($qty);
        //monto iva
        $montoIva = $subtotalNeto  * $iva;
        //total con iva
        $totalConIva =  $subtotalNeto + $montoIva;


        return [
            'sale_price' => $salePrice,
            'neto' => $subtotalNeto,
            'iva' => $montoIva,
            'total' => $totalConIva
        ];
    }


    function totalIVA()
    {
        $iva = $this->cart->sum(function ($product) {
            return $product['tax'];
        });

        return $iva;
    }

    function totalCart()
    {
        $amount = $this->cart->sum(function ($product) {
            return $product['total'];
        });
        return $amount;
    }

    function totalItems()
    {
        $items = $this->cart->sum(function ($product) {
            return $product['qty'];
        });
        return $items;
    }


    function subtotalCart()
    {
        $subt = $this->cart->sum(function ($product) {
            return $product['qty'] * $product['sale_price'];
        });
        return $subt;
    }

    function clear()
    {
        $this->cart = new Collection;
        $this->save();
        $this->emit('refresh');
    }
}
