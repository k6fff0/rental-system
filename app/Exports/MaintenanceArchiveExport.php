<?php

namespace App\Exports;

use App\Models\MaintenanceRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class MaintenanceArchiveExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = MaintenanceRequest::with(['unit', 'building', 'technician', 'subSpecialty'])
            ->whereIn('status', ['completed', 'rejected']);

        if ($this->request->filled('unit_id')) {
            $query->where('unit_id', $this->request->unit_id);
        }

        if ($this->request->filled('assigned_worker_id')) {
            $query->where('assigned_worker_id', $this->request->assigned_worker_id);
        }

        if ($this->request->filled('sub_specialty_id')) {
            $query->where('sub_specialty_id', $this->request->sub_specialty_id);
        }

        if ($this->request->filled('from') && $this->request->filled('to')) {
            $query->whereBetween('created_at', [$this->request->from, $this->request->to]);
        }

        $requests = $query->latest()->get();

        return view('admin.maintenance_requests.exports.excel', [
            'requests' => $requests
        ]);
    }
}
