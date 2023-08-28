<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Exports\SalesExport;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalesReport extends Component
{
    use WithPagination;

    public $startDate, $endDate, $users, $selectedUser, $reportType;
    public $detail = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->users = User::orderBy('name')->get();
        $this->selectedUser = 0;
        $this->reportType = 0;
    }

    protected $listeners = ['refresh' => '$refresh'];


    public function render()
    {
        return view('livewire.reports.sales-report', [
            'data' => $this->getReport()
        ]);
    }

    function getReport()
    {
        if ($this->startDate == null || $this->endDate == null) return [];

        $startDate = Carbon::parse($this->startDate)->startOfDay(); // 2023-08-20 00:00:00
        $endDate = Carbon::parse($this->endDate)->endOfDay(); //2023-08-20 23:59:59
        $usersArray = $this->selectedUser == 0 ? $this->users->pluck('id')->toArray() : [$this->selectedUser];
        $info = [];

        //todos los usuarios
        if ($this->reportType == 0) {
            $info = Sale::with(['customer', 'user', 'details.product'])->whereIn('user_id', $usersArray)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('id', 'desc')->paginate(10);
        }

        // top 10
        if ($this->reportType == 1) {
            $info = Product::select(
                'products.name as product',
                'products.id',
                DB::raw('sum(sale_details.quantity)as qty_sold'),
                DB::raw('sum(sale_details.quantity * sale_details.price) as total')
            )
                ->join('sale_details', 'products.id', 'sale_details.product_id')
                ->join('sales', 'sale_details.sale_id', 'sales.id')
                ->whereBetween('sales.created_at', [$startDate, $endDate])
                ->whereIn('sales.user_id', $usersArray)
                ->groupBy('products.id')
                ->orderByDesc('qty_sold')
                ->limit(10)
                ->get();
        }


        return $info;
    }

    function showDetail($sale)
    {
        $data = json_decode($sale, true);
        //dd($data);
        $this->detail = $data['details'];

        $this->dispatchBrowserEvent('show-detail');
    }

    function Export()
    {
        $fileName = 'report_' . uniqid() . '.xlsx';

        $user = $this->selectedUser == 0 ? 'All users' : $this->users->where('id', $this->selectedUser)->first()->name;

        return Excel::download(new SalesExport($this->getReport(), $user, $this->reportType), $fileName);
    }
}
