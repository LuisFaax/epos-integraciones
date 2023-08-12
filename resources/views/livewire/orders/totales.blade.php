<div class="card">
    <div class="card-header">
        <span class="text-primary h3">Totales</span>
    </div>
    <div class="card-body p-3">
        <div>
            <span class="text-white">ITEMS:</span>
            <span class="float-right text-info">
                {{ $itemsCart }}
            </span>
        </div>
        <div>
            <span class="text-white">SUBTOTAL:</span>
            <span class="float-right text-info">
                ${{ $subtotalCart }}
            </span>
        </div>
        <div>
            <span class="text-white">TAX:</span>
            <span class="float-right text-info">
                ${{ $taxCart }}
            </span>
        </div>
        <hr>
        <div>
            <span class="text-white"><b>TOTAL</b></span>
            <span class="float-right text-info">
                <b>${{ $totalCart }}</b>
            </span>
        </div>

        <div class="form-group mt-5">
            <button onclick="ConfirmSave()" class="btn btn-primary btn-sm btn-block " {{ $totalCart> 0 ? '' :
                'disabled'
                }}>Save F4</button>
        </div>
        <div class="form-group mt-5">
            <button wire:click.prevent="clearCart" class="btn btn-dark btn-sm btn-block " {{ $totalCart> 0 ? '' :
                'disabled'
                }}>Cancel</button>
        </div>
    </div>
</div>