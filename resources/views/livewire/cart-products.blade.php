<div>
    <div class="card">
        <div class="card-header">

            <div class="input-group search-area d-xl-inline-flex d-none w-100">
                {{-- al pulsar enter asignamos el valor del input a la propiedad search, el componente reacciona y
                muestra los resultados de la busqueda --}}
                <input wire:model.defer="search" wire:keydown.enter.prevent="$emit('refresh')" type="text"
                    class="form-control text-center" placeholder="Search  by description and barcode" id="inputFocus"
                    autocomplete="off">
                <div class="input-group-append">
                    <button class="input-group-text"><i class="flaticon-381-search-2"></i></button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                {{-- renderiza productos de la categoria seleccionada o por defecto --}}
                @foreach ($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 ">
                    <div class="card text-center bg-warning">
                        {{-- emitimos el evento add-product pasando el id del producto, el evento lo escucha el
                        componente padre Sales y agrega el producto a la sesion del carrito --}}
                        <img src="{{ $product->photo }}" class="card-img-top w-full rounded-lg"
                            wire:click.prevent="$emit('add-product', {{ $product->id }})" alt="{{ $product->name }}"
                            height="40%">

                        <div class="card-body p-0 d-flex flex-column">
                            <div class="flex-grow-1 text-center">
                                <h6 class="card-title mt-2">{{ $product->name }}</h6>
                            </div>
                            <div class="mb-2">
                                <span class="card-text text-secondary h6 ">$ <b>{{ $product->price }}</b></span>
                            </div>
                        </div>
                        <div class="card-footer p-0 border-0">
                            <button wire:click.prevent="$emit('add-product', {{ $product->id }})"
                                class="btn btn-dark btn-sm btn-block">Add</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .mb-2 {
            text-align: center;
        }

        .card-title {
            font-size: 15px !important;
        }
    </style>

</div>