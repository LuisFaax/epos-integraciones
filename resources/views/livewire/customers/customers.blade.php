<div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $editing ? 'Edit Customer' : 'Create Customer' }}</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>First Name</label>
                        <input wire:model.defer="customer.first_name" id='inputFocus' type="text"
                            class="form-control form-control-lg" placeholder="first name" autocomplete="nope">
                        @error('customer.first_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input wire:model.defer="customer.last_name" type="text" class="form-control form-control-lg"
                            placeholder="last name">
                        @error('customer.last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input wire:model.defer="customer.email" type="text" class="form-control form-control-lg"
                            placeholder="email">
                        @error('customer.email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input wire:model.defer="customer.phone" type="text" class="form-control form-control-lg"
                            placeholder="phone">
                        @error('customer.phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>




                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-dark float-left hidden {{$editing ? 'd-block' : 'd-none' }}"
                        wire:click="cancelEdit">Cancel</button>
                    <button class="btn btn-sm btn-info float-right save" wire:click="Store">Save</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex">
                        <div class="separator"></div>
                        <div class="mr-auto">
                            <h4 class="card-title mb-1">Customers</h4>
                            <p class="fs-14 mb-0"> Listado Registrado</p>
                        </div>
                    </div>
                    <div class="float-right">
                        <button class="btn tp-btn-light btn-success btn-xs" wire:click="SyncDown">
                            <i class="las la-download la-2x"></i>
                        </button>
                        <button class="btn tp-btn-light btn-success btn-xs" wire:click="Add">
                            <i class="las la-plus la-2x"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md table-hover  text-center">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-left">First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $item)
                                <tr>
                                    <td class="text-left">
                                        <span class="{{ $item->platform_id !=null ? 'text-success' : '' }}">
                                            {{ $item->first_name }}
                                        </span>
                                    </td>
                                    <td> {{ $item->last_name }} </td>
                                    <td> {{ $item->email }} </td>
                                    <td> {{ $item->phone }} </td>

                                    <td class="text-right">

                                        <div class="dropdown position-static">
                                            <button class="btn btn-info dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"
                                                    wire:click.prevent="deliveryForm({{ $item->id }})"><i
                                                        class="las la-truck la-2x"></i> Delivery
                                                </a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click.prevent="Edit({{ $item->id }})"><i
                                                        class="las la-pen la-2x"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="Confirm('customers',{{ $item->id }})"><i
                                                        class="las la-trash-alt la-2x"></i> Delete
                                                </a>
                                                @if($item->platform_id == null)
                                                <a class="dropdown-item save" href="#"
                                                    wire:click.prevent="Sync({{ $item->id }})"><i
                                                        class="las la-sync la-2x"></i> Sync
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No hay customers</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            {{$customers->links()}}
                        </div>
                        <div class="col-md-6"><span class="float-right">Records:{{$records}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.customers.delivery')

    <script>
        document.addEventListener('livewire:load', function () {
        var mainWrapper = document.getElementById('main-wrapper')        
            mainWrapper.classList.add('menu-toggle')  
    })

    window.addEventListener('modal-delivery', event => {   
      $('#modalDelivery').modal('show')
      setTimeout(() => {
        document.getElementById('inputDeliveryName').focus()
      }, 1000);
   })

    </script>
</div>