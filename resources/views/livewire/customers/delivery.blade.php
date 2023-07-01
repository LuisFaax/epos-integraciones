<div wire:ignore.self id="modalDelivery" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Customer | Shipping | Billing Info</h4>
            </div>
            <div class="modal-body">
                <form action="" autocomplete="new">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <label>First Name*</label>
                            <input wire:model.defer="delivery.first_name" id='inputDeliveryName' type="text"
                                class="form-control form-control-lg" placeholder="first name" autocomplete="none">
                            @error('delivery.first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Last Name</label>
                            <input wire:model.defer="delivery.last_name" type="text"
                                class="form-control form-control-lg" placeholder="last name">
                            @error('delivery.last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Company</label>
                            <input wire:model.defer="delivery.email" type="text" class="form-control form-control-lg"
                                placeholder="company">
                            @error('delivery.email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label>Address 1</label>
                            <input wire:model.defer="delivery.address1" type="text" class="form-control form-control-lg"
                                placeholder="address1">
                            @error('delivery.address1') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Address 2</label>
                            <input wire:model.defer="delivery.address2" type="text" class="form-control form-control-lg"
                                placeholder="address2">
                            @error('delivery.address2') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <label>City</label>
                            <input wire:model.defer="delivery.city" type="text" class="form-control form-control-lg"
                                placeholder="city">
                            @error('delivery.city') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>State</label>
                            <input wire:model.defer="delivery.state" type="text" class="form-control form-control-lg"
                                placeholder="state">
                            @error('delivery.state') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Post Code</label>
                            <input wire:model.defer="delivery.postcode" type="text" class="form-control form-control-lg"
                                placeholder="postcode">
                            @error('delivery.postcode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <label>Email</label>
                            <input wire:model.defer="delivery.email" type="text" class="form-control form-control-lg"
                                placeholder="email">
                            @error('delivery.email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Phone</label>
                            <input wire:model.defer="delivery.phone" type="text" class="form-control form-control-lg"
                                placeholder="phone">
                            @error('delivery.phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Country</label>
                            <input wire:model.defer="delivery.country" type="text" class="form-control form-control-lg"
                                placeholder="country">
                            @error('delivery.country') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="row mt-4 d-flex align-items-center">
                        <div class="col-sm-12 col-md-4">
                            <select wire:model.defer="delivery.type" class="form-control form-control-lg">
                                <option value="billing">Billing</option>
                                <option value="shipping">Shipping</option>
                            </select>
                            @error('delivery.type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-12 col-md-8 ">
                            @if(!isset($delivery['id']))
                            <button class="btn btn-sm btn-info float-right save"
                                wire:click.prevent="saveDelivery">Save</button>
                            @else
                            <button class="btn btn-sm btn-warning float-right"
                                wire:click.prevent="cancelEditDelivery">Cancel</button>
                            <button class="btn btn-sm btn-info float-right save mr-4"
                                wire:click.prevent="updateDelivery">Update</button>
                            @endif
                        </div>
                    </div>


                </form>

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-responsive-md table-hover  text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-left">First Name</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($customerSelected !=null)
                                    @foreach ($customerSelected->deliveries as $dely)
                                    <tr>
                                        <td class="text-left">{{$dely->first_name}}</td>
                                        <td> {{$dely->address1}}</td>
                                        <td> {{ucfirst($dely->type)}}</td>
                                        <td>
                                            <button wire:click.prevent="editDelivery({{ $dely->id }})"
                                                class="btn  tp-btn btn-dark btn-xxs"><i class="las la-edit la-2x"></i>
                                            </button>
                                            <button wire:click.prevent="removeDelivery({{ $dely->id }})"
                                                class="btn  tp-btn btn-dark btn-xxs"><i class="las la-trash la-2x"></i>
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>