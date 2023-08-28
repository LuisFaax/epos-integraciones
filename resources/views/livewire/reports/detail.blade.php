<div id="modalDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Sale Details #{{ $detail[0]['sale_id'] ?? ''}}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table ">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>DESCRIPTION</th>
                            <th>QUANTITY</th>
                            <th>PRICE</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detail as $row)
                        <tr class="text-center">
                            <td>{{ $row['id']}}</td>
                            <td>{{ $row['product']['name']}}</td>
                            <td>{{ $row['quantity']}}</td>
                            <td>${{ $row['price']}}</td>
                            <td>${{ $row['quantity'] * $row['price']}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td>No hay detalles</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="text-center text-white bg-dark">
                            <td colspan="2" class="text-left">TOTALES</td>
                            <td> {{collect($detail)->sum('quantity')}}</td>
                            <td></td>
                            <td>
                                @php
                                $total = collect($detail)->sum(function ($item) {
                                return $item['quantity'] * $item['price'];
                                });
                                @endphp
                                ${{$total}}
                            </td>

                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-dark " data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>