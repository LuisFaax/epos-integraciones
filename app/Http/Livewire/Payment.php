<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Traits\SaleTrait;
use App\Models\SaleDetail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Payment extends Component
{
    use WithPagination;
    use SaleTrait;

    public $totalCart, $itemsCart, $cash, $customerId;


    protected $paginationTheme = 'bootstrap';


    public function mount($totalCart, $itemsCart)
    {
        $this->totalCart = $totalCart;
        $this->itemsCart = $itemsCart;
    }


    protected $listeners = [
        'refresh' => '$refresh',
        'customerId' => 'setCustomerId'
    ];

    function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }


    public function render()
    {
        return view('livewire.payment', [
            'change' => $this->change,
        ]);
    }

    function getChangeProperty()
    {

        if (!is_numeric($this->totalCart) || !is_numeric($this->cash)) {
            return 0;
        }


        return round($this->cash - $this->totalCart);
    }


    function Store()
    {

        if (!session()->has('cart')) {
            $this->dispatchBrowserEvent('noty-error', ['msg' => 'CARRITO VACÍO, AGREGA PRODUCTOS']);
            return;
        }

        if ($this->customerId == null) {
            $this->dispatchBrowserEvent('noty-error', ['msg' => 'SELECCIONA EL CLIENTE']);
            return;
        }
        //VALIDAR EL CASH/EFECTIVO > TOTALCART

        //recuperamos carrito
        $cart = session('cart');

        try {

            DB::transaction(function () use ($cart) {

                //guardar venta
                $sale =  Sale::create([
                    'total' => $this->totalCart,
                    'discount' => 0,
                    'items' => $this->itemsCart,
                    'customer_id' => $this->customerId,
                    'user_id' => Auth()->user()->id
                ]);


                //forma optimizada / recomendada
                $details = $cart->map(function ($item) use ($sale) {
                    return [
                        'product_id' => $item['pid'],
                        'sale_id' => $sale->id,
                        'quantity' => $item['qty'],
                        'price' => $item['sale_price']
                    ];
                })->toArray();

                //option 1
                //$sale->details()->createMany($details);

                // option 2
                SaleDetail::insert($details);


                //sync stocks
                $dataProducts = ['update' => []];

                foreach ($cart as $item) {
                    $product = Product::find($item['pid']);
                    $product->stock_qty -= $item['qty'];
                    $product->save();

                    $newStock = $product->stock_qty;
                    $dataProducts['update'][] = [
                        'id' => $item['platform_id'],
                        'stock_quantity' => $newStock
                    ];
                }

                $resultSync = $this->SyncBatchStock($dataProducts);


                $this->reset();
                $this->dispatchBrowserEvent('close-payment');
                $this->dispatchBrowserEvent('noty', ['msg' =>  $resultSync ? "VENTA REGISTRADA - STOCK SINCRONIZADO" : "FALLA DE SINCRONIZACIÓN"]);
                //
                $this->emit('clear-cart');
            });
            //
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('noty-error', ['msg' => "Ocurrió una excepción \n {$th->getMessage}"]);
        }
    }
}
