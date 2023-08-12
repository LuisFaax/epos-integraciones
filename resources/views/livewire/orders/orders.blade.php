<div>
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="card">
                <div class="card-header">
                    <span class="text-primary h3">Order Items</span>
                </div>
                <div class="card-body p-1">

                    <livewire:live-search />

                    <div class="table-responsive">

                        <table class="table table-striped table-responsive-sm">
                            <thead>
                                <tr class="text-center text-white">
                                    <th width="100" class="text-left"></th>
                                    <th class="text-center">Description</th>
                                    <th width="140">Qty</th>
                                    <th width="160">Price</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>



                                @forelse($order as $item)
                                <tr class="text-center text-warning">

                                    <td class="text-left">
                                        <img alt="photo" class="img-fluid rounded" src="{{ asset($item['image']) }}"
                                            width="50">

                                    </td>
                                    <td>
                                        <div> {{ $item['name']}}</div>
                                        <small class="text-dark">stock: {{ intval($item['stock_qty']) }}</small>
                                    </td>

                                    <td class="text-center ">
                                        <input
                                            wire:keydown.enter.prevent="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                            class="form-control form-control-lg text-center text-warning" type="number"
                                            value="{{ $item['quantity'] }}">
                                    </td>

                                    <td>
                                        <input
                                            wire:keydown.enter.prevent="updateCost('{{ $item['id'] }}', $event.target.value)"
                                            class="form-control form-control-lg text-center text-warning" type="number"
                                            value="{{ $item['price'] }}">

                                    </td>


                                    <td>${{ $item['amount'] }}</td>
                                    <td>
                                        <button wire:click.prevent="removeProduct({{ $item['id'] }})"
                                            class="btn tp-btn  btn-danger" style="padding: 0.538rem 0.7rem!important;">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </button>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Add products to cart</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-3">
            @include('livewire.orders.totales')
        </div>

    </div>
    <input type="hidden" id="inputFocus">

    <script>
        document.addEventListener('addProductFromSearch', event => {
          
            setTimeout(() => {                
                document.getElementById('searchBox').focus()
            }, 1000);
        })

        document.addEventListener('set-placeholder-ref-price', event => {
            document.getElementById("inputPrice").placeholder = 'ref $' + event.detail.value;
        })


        document.addEventListener('keydown', function(event) {
            if (event.key === 'F1') {     
                event.preventDefault()          
                document.getElementById('searchBox').focus()
            } else if (event.key === 'F2') {                
                event.preventDefault()
                document.getElementById('inputQty').focus();
            } else if (event.key === 'F3') {                
                event.preventDefault()
                document.getElementById('inputPrice').focus();            
            } else if (event.key === 'F4') {                
                event.preventDefault()
                ConfirmSave()
            }
        })

       

    function ConfirmSave() {    
        //validate cart    
        var totalCart = @this.totalCart
            if(totalCart <=0) {
                toastr.error("ADD PRODUCTS TO CART", "Info", {
                    positionClass: "toast-bottom-center",
                    closeButton: !0,
                    progressBar: !0
                })
                return false
            }
            
            
            Swal.fire({
            title: '¿CONFIRMAR GUARDAR VENTA?',
            text: "",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.value) {    
                showProcessing()
                @this.saveOrder()
            }
            })
    }

    </script>
</div>