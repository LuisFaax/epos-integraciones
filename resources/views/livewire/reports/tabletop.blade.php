<table class="table table-responsive-md table-hover  text-center">
    <thead class="thead-primary">
        <tr>
            <th>ID</th>
            <th>PRODUCT</th>
            <th>QUANTITY</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->product}}</td>
            <td>{{$item->qty_sold}}</td>
            <td>${{$item->total}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No se encontraron ventas</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="text-white bg-dark">
            <td colspan="2" class="text-left">TOTALES</td>
            <td>{{ count($data) >0 ? $data->sum('qty_sold') : '' }}</td>
            <td>{{ count($data) >0 ? '$'. $data->sum('total') : '' }}</td>

        </tr>
    </tfoot>
</table>