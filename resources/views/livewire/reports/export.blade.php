<table class="table table-responsive-md table-hover  text-center">
    <thead class="thead-primary">
        <tr>
            <th>ID</th>
            <th>TOTAL</th>
            <th>ITEMS</th>
            <th>CUSTOMER</th>
            <th>USER</th>
            <th>DATE</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->total}}</td>
            <td>{{$item->items}}</td>
            <td>{{$item->customer->first_name}} {{$item->customer->last_name}}</td>
            <td>{{$item->user->name}}</td>
            <td>{{$item->created_at}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No se encontraron ventas</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="text-white bg-dark">
            <td>TOTALES</td>
            <td>{{ count($data) >0 ? '$'. $data->sum('total') : '' }}</td>
            <td>{{ count($data) >0 ? $data->sum('items') : '' }}</td>

        </tr>
    </tfoot>
</table>