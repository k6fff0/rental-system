<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Unit;
use App\Models\Building;
use App\Models\Tenant;

Route::get('/units-by-building/{building}', function (Building $building, Request $request) {
    $tenantId = $request->query('tenant_id');

    $currentUnitId = null;

    if ($tenantId) {
        $tenant = Tenant::find($tenantId);
        $currentUnitId = $tenant?->unit_id;
    }

    $units = $building->units()
        ->where(function ($query) use ($currentUnitId) {
            $query->whereDoesntHave('tenant');

            if ($currentUnitId) {
                $query->orWhere('id', $currentUnitId);
            }
        })
        ->select('id', 'unit_number')
        ->get();

    return response()->json($units);
});