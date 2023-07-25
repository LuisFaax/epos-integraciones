<div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="input-group search-area d-xl-inline-flex d-none w-100">
                        {{-- con wire:model enlazamos la propiedad search y logramos buscar la categoria al pulsar
                        enter, al mismo tiempo emitimos el evento refresh para que el propio componente se recargue--}}
                        <input wire:model.defer="search" wire:keydown.enter.prevent="$emit('refresh')" type="text"
                            class="form-control text-center" placeholder="Search category">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="flaticon-381-search-2"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-1">
                    @foreach($categories as $category)
                    <div class="col">
                        {{-- al hacer click sobre la tarjeta, emitimos el evento categorySelected con la categoria, esto
                        lo escucha el componente cart-products y muestra los productos relacionados --}}
                        <div class="card" wire:click="$emit('categorySelected', {{ $category->id }})">
                            <div class="card-body p-0 text-center">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid rounded" src="{{ $category->picture }}" alt="category"
                                            style="width: 50%!important">
                                    </div>
                                    <div class="new-arrival-content text-center mt-2">
                                        <h5 class="text-secondary">{{ $category->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>