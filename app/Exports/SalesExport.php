<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SalesExport implements FromView, ShouldAutoSize
{

    public $data, $user, $type;

    public function __construct($data, $user, $type)
    {
        $this->data = $data;
        $this->user = $user;
        $this->type = $type;
    }

    public function view(): View
    {
        return view($this->type == 0 ? 'livewire.reports.export' : 'livewire.reports.exporttop', [
            'data' => $this->data,
            'user' => $this->user,
            'type' => $this->type,
        ]);
    }
}
