<table class="table table-light">
    <tbody>
        <tr>
            <td colspan="4" style="text-align: center"><b>SALES REPORT</b></td>
        </tr>
        <tr>
            <td colspan="2"><b>User: {{$user}} </b></td>
            <td colspan="2"><b>Type: {{$type == 0 ? 'General' : 'Top 10' }} </b></td>
        </tr>
    </tbody>
</table>

<table class="table table-responsive-md table-hover  text-center">
    <thead class="thead-primary">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">PRODUCT</th>
            <th style="text-align: center">QUANTITY</th>
            <th style="text-align: center">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td style="text-align: center">{{$item->id}}</td>
            <td style="text-align: center">{{$item->product}}</td>
            <td style="text-align: center">{{$item->qty_sold}}</td>
            <td style="text-align: center">${{$item->total}}</td>
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
            <td style="text-align: center">{{ count($data) >0 ? $data->sum('qty_sold') : '' }}</td>
            <td style="text-align: center">{{ count($data) >0 ? '$'. $data->sum('total') : '' }}</td>

        </tr>
    </tfoot>
</table>