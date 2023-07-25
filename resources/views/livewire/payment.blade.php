<div>
    <div wire:ignore.self class="modal fade" id="modalPayment" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- TOTAL --}}
                    <div>
                        <span class="text-white h2"><b>TOTAL:</b></span>
                        <span class="float-right text-primary h1">${{ $totalCart }}</span>
                    </div>

                    {{-- tomSelect --}}
                    <div class=" input-group w-100" wire:ignore>
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="las la-user-alt"></i></button>
                        </div>
                        <input type="text" class="form-control form-control-lg" placeholder="Customer " id="tomCustomer"
                            autocomplete="off" autofocus>
                    </div>

                    {{-- Cash --}}
                    <div class="input-group w-100 mt-4">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="las la-dollar-sign white"></i></button>
                        </div>
                        <input wire:model.debounce.750ms="cash" type="number" class="form-control form-control-lg"
                            placeholder="Cash" id="inputCash">
                        @error('cash') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group w-100 mt-4">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="las la-hand-holding-usd"></i></button>
                        </div>
                        <input type="text" class="form-control form-control-lg" value="{{ $change }}" disabled>
                    </div>

                    <div class="form-group mt-4">
                        <button type="button" onclick="alert('Función solo para miembros lifetime')"
                            class="btn btn-info btn-block btn-sm">
                            <i class="lab la-paypal la-2x"></i>
                            PAY WITH PAYPAL
                        </button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark light" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="Store" class="btn btn-info ml-5 save" {{ $totalCart> $cash
                        ?
                        'disabled' : ''
                        }}>Save</button>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* estilos tom select */
        .ts-control {
            padding: 0px !important;
            border-style: none;
            border-width: 0px !important;
            background: #0E0803 !important;
            font-size: 18px;
            height: 26px;
            color: white;
        }

        .ts-control input {
            color: rgb(242, 6, 6) !important;
            font-size: 1rem !important;
        }

        .ts-wrapper.multi .ts-control>div {
            font-size: 1rem !important;
            color: white !important;
            background-color: orange;
        }

        .search-area .input-group-append .input-group-text i {
            font-size: 16px !important;
        }
    </style>
</div>