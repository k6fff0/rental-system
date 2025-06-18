<?php

namespace App\Livewire;

use App\Models\Building;
use App\Models\MaintenanceRequest;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceTable extends Component
{
    use WithPagination;

    public $building_id;
    public $status;
    public $sub_specialty_id;
    public $technician_id;
    public $unit_number;
    public $perPage = 10;

    protected $queryString = [
        'building_id',
        'status',
        'sub_specialty_id',
        'technician_id',
        'unit_number',
        'perPage'
    ];

    public function updating($field)
    {
        $this->resetPage();
    }

    public function render()
    {
        $requests = MaintenanceRequest::with(['building', 'unit', 'technician', 'unit.activeContract.tenant', 'subSpecialty.parent'])
            ->when($this->building_id, fn($q) => $q->where('building_id', $this->building_id))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->sub_specialty_id, fn($q) => $q->where('sub_specialty_id', $this->sub_specialty_id))
            ->when($this->technician_id, fn($q) => $q->where('assigned_worker_id', $this->technician_id))
            ->when($this->unit_number, function ($q) {
                $q->whereHas('unit', function ($query) {
                    $query->where('unit_number', 'LIKE', '%' . $this->unit_number . '%');
                });
            })
            ->whereNotIn('status', ['completed', 'rejected'])
            ->orderByRaw('GREATEST(UNIX_TIMESTAMP(updated_at), UNIX_TIMESTAMP(created_at)) DESC')
            ->paginate($this->perPage);

        $buildings = Building::all();
        $subSpecialties = Specialty::subtasks()->with('parent')->get();
        $technicians = User::role('technician')->get();

        $totalCount = MaintenanceRequest::count();
        $statusCounts = MaintenanceRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('livewire.maintenance-table', compact(
            'requests',
            'buildings',
            'subSpecialties',
            'technicians',
            'totalCount',
            'statusCounts'
        ));
    }
}
