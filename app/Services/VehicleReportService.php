<?php

namespace App\Services;

use App\Models\VehicleExpense;
use App\Models\Violation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehicleReportService
{
    public static function getReportData(Request $request): array
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : null;
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : null;
        $vehicleId = $request->vehicle_id;
        $userId = $request->user_id;

        $expenses = VehicleExpense::query();
        $violations = Violation::query();

        if ($startDate) {
            $expenses->where('date', '>=', $startDate);
            $violations->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $expenses->where('date', '<=', $endDate);
            $violations->where('date', '<=', $endDate);
        }

        if ($vehicleId) {
            $expenses->where('vehicle_id', $vehicleId);
            $violations->where('vehicle_id', $vehicleId);
        }

        if ($userId) {
            $violations->where('user_id', $userId);
        }

        return [
            'expenses' => $expenses->with('vehicle')->get(),
            'violations' => $violations->with(['vehicle', 'user'])->get(),
        ];
    }
}
