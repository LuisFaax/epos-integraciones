<div>
    <div class="card">
        <div class="card-header">
            <span class="text-primary h3">Products in Cart</span>
        </div>
        <div class="card-body p-1">
            <div class="table-responsive">

                <table class="table table-striped table-responsive-sm">
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Description</th>
                            <th width="90">Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cartInfo as $item)
                        <tr class="text-center">

                            <td class="border-b whitespace-nowrap" width="10%">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="photo" class="img-fluid rounded" src="{{ asset($item['image']) }}"
                                        width="50">
                                </div>
                            </td>
                            <td class="text-left">{{ $item['name'] }}
                            </td>
                            <td>
                                <input
                                    wire:keydown.enter.prevent="$emit('updateQty', '{{ $item['id'] }}', $event.target.value)"
                                    class="form-control form-control-sm text-center" type="numeric"
                                    value=" {{ $item['qty'] }}" placeholder="form-control-sm">

                            </td>
                            <td>${{ $item['sale_price'] }}</td>
                            <td>${{ $item['total'] }}</td>
                            <td>
                                <button wire:click.prevent="$emit('removeItem', '{{ $item['id'] }}' )"
                                    class="btn tp-btn btn-xxs btn-danger "><i class="fa fa-trash fa-lg"></i></button>
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