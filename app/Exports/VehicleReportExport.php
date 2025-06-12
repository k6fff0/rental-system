<?php

namespace App\Exports;

use App\Models\VehicleExpense;
use App\Models\Violation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use App\Services\VehicleReportService;

class VehicleReportExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
{
    $data = VehicleReportService::getReportData($this->request);

    return view('admin.vehicles.reports.excel', $data);
}
}
