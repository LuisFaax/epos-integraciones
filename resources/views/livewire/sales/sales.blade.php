<div>


    <div class="row">


        <div class="col-sm-12 col-md-2">

            <livewire:category-pos />
        </div>

        <div class="col-sm-12 col-md-4">
            <livewire:cart-products />
        </div>

        <div class="col-sm-12 col-md-4">
            <livewire:cart-view />
        </div>

        <div class="col-sm-12 col-md-2">
            @include('livewire.sales.cardTotales')
        </div>


    </div>


    <div>
        <livewire:payment :totalCart="$totalCart" :itemsCart="$itemsCart" :key="$totalCart" />
    </div>


    @include('livewire.sales.js')

</div>