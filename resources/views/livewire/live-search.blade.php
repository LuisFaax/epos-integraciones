<div class="row" x-data="{ open: false }" @click.away="open = false">

    <div class="col-sm-12 col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="las fa-search"></i></span>
            </div>

            <input wire:model="query" @focus="open = true" @keydown.escape.window="open = false"
                class="form-control form-control-lg text-warning" type="text" placeholder="Search product (F1)"
                id="searchBox">
        </div>

        <ul x-show="open" class="list-group position-absolute" style="width: 100%; z-index: 99;">
            @foreach ($products as $index => $product)
            <li wire:click="selectProduct({{ $product->id }})" @click="$refs.inputQty.focus(); open = false;"
                class="list-group-item list-group-item-action {{ $index % 2 == 0 ? 'bg-light' : 'bg-dark' }}"
                style="font-weight: bold; cursor: pointer; color:orange; ">
                {{ $product->name }}
            </li>
            @endforeach
        </ul>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Quantity</span>
            </div>
            <input type="number" wire:model.defer="quantity"
                class="form-control form-control-lg text-center text-warning" x-ref="inputQty" placeholder="1 (f2)"
                id="inputQty">
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Price</span>
            </div>
            <input type="number"
                wire:keydown.enter.prevent="{{$selectedProduct !=null && $price > 0  ? 'addSelectedProduct'  : '' }}"
                wire:model="price" class="form-control form-control-lg text-center text-warning" x-ref="inputPrice"
                id="inputPrice" placeholder="price (f3)">
        </div>
    </div>

</div>