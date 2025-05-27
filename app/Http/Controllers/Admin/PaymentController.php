<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\User;
use App\Models\PaymentLog;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view payments')->only(['index', 'show']);
        $this->middleware('permission:create payments')->only(['create', 'store']);
        $this->middleware('permission:edit payments')->only(['edit', 'update']);
        $this->middleware('permission:delete payments')->only(['destroy']);
    }

    public function index(Request $request)
{
    $query = Payment::with(['contract.tenant', 'collector']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('contract.tenant', fn($q2) => $q2->where('name', 'like', "%$search%"))
              ->orWhereHas('collector', fn($q2) => $q2->where('name', 'like', "%$search%"))
              ->orWhereHas('contract', fn($q2) => $q2->where('contract_number', 'like', "%$search%"))
              ->orWhere('method', 'like', "%$search%")
              ->orWhere('month_for', 'like', "%$search%");
        });
    }

    $payments = $query->latest()->paginate(10);

    return view('admin.payments.index', compact('payments'));
}

public function show(Payment $payment)
{
    return view('admin.payments.show', compact('payment'));
}

    public function create()
    {
        $contracts = Contract::with('tenant')->where('status', 'active')->get();
        return view('admin.payments.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id'   => 'required|exists:contracts,id',
            'amount'        => 'required|numeric|min:0.01',
            'payment_date'  => 'required|date',
            'month_for'     => 'required|date_format:Y-m',
            'method'        => 'nullable|string|max:255',
            'notes'         => 'nullable|string|max:1000',
        ]);

        $validated['month_for'] = Carbon::createFromFormat('Y-m', $validated['month_for'])->startOfMonth();
        $validated['payer_id'] = auth()->id();
        $validated['collector_id'] = auth()->id();

        Payment::create($validated);

        return redirect()->back()->with('success', __('messages.payment_added_successfully'));
    }
	
	public function edit(Payment $payment)
{
    // نجيب العقود عشان نعرضهم في قائمة منسدلة لو حبيت تعدل العقد المرتبط
    $contracts = Contract::with('tenant')->get();

    return view('admin.payments.edit', compact('payment', 'contracts'));
}

public function update(Request $request, Payment $payment)
{
    $validated = $request->validate([
        'contract_id' => 'required|exists:contracts,id',
        'amount' => 'required|numeric|min:0.01',
        'payment_date' => 'required|date',
        'month_for' => 'required|date_format:Y-m',
        'method' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:1000',
    ]);

    // تحويل الشهر لأول يوم في الشهر
    $validated['month_for'] = \Carbon\Carbon::createFromFormat('Y-m', $validated['month_for'])->startOfMonth();

    // احفظ البيانات الأصلية
    $original = $payment->only(['amount', 'month_for']);
    $original['amount'] = number_format((float)$original['amount'], 2, '.', '');
    $validated['amount'] = number_format((float)$validated['amount'], 2, '.', '');

    // المقارنة وتكوين التغييرات
    $changes = [];
    foreach (['amount', 'month_for'] as $field) {
        if ($validated[$field] != $original[$field]) {
            $changes['before'][$field] = $original[$field];
            $changes['after'][$field] = $validated[$field];
        }
    }

    // تحديث الدفعة
    $payment->update($validated);

    // لو في تغييرات بس، سجل لوج
    if (!empty($changes)) {
        \App\Models\PaymentLog::create([
            'payment_id' => $payment->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'changes' => $changes,
        ]);
    }

    return redirect()->route('admin.payments.index')->with('success', __('messages.payment_updated_successfully'));
}



public function monthlyDueReport(Request $request)
{
    $month = $request->input('month', now()->format('Y-m'));
    $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
    $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

    $contracts = Contract::with([
        'tenant',
        'unit.building',
        'payments' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('month_for', [$startOfMonth, $endOfMonth]);
        },
        'payments.collector'
    ])->where('status', 'active')->get();

    $data = $contracts->map(function ($contract) {
        $paid = $contract->payments->sum('amount');
        $due = $contract->rent_amount;
        $remaining = $due - $paid;

        // اسم أول محصل دفع خلال هذا الشهر (أو null)
        $firstPayment = $contract->payments->first();
        $collectorName = $firstPayment && $firstPayment->collector
            ? $firstPayment->collector->name
            : '—';

        return [
            'tenant' => $contract->tenant->name,
            'contract_code' => $contract->contract_number,
            'building' => optional($contract->unit->building)->name,
            'unit' => $contract->unit->unit_number,
            'collector' => $collectorName,
            'due' => $due,
            'paid' => $paid,
            'remaining' => $remaining,
            'status' => $paid >= $due ? __('messages.paid') : ($paid > 0 ? __('messages.partial') : __('messages.unpaid')),
        ];
    });

    return view('admin.payments.due_report', compact('data', 'month'));
}

    public function exportExcel(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $contracts = $this->getDueContractsData($month);

        $export = new \App\Exports\MonthlyDueExport($contracts, $month);
        return Excel::download($export, 'monthly_due_report_' . $month . '.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $contracts = $this->getDueContractsData($month);

        $pdf = Pdf::loadView('admin.payments.due_report_pdf', [
            'data' => $contracts,
            'month' => $month,
        ]);

        return $pdf->download('monthly_due_report_' . $month . '.pdf');
    }

    protected function getDueContractsData($month)
    {
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $contracts = Contract::with([
            'tenant',
            'unit.building',
            'payments.collector' => fn ($q) => $q->whereBetween('month_for', [$start, $end])
        ])->where('status', 'active')->get();

        return $contracts->map(function ($contract) use ($start) {
            $paid = $contract->payments->sum('amount');
            $due = $contract->rent_amount;
            $remaining = $due - $paid;

            $collectorName = $contract->payments->first()?->collector?->name ?? '—';

            return [
                'tenant' => $contract->tenant->name,
                'contract_code' => $contract->contract_number,
                'building' => optional($contract->unit->building)->name,
                'unit' => $contract->unit->unit_number,
                'collector' => $collectorName,
                'due' => $due,
                'paid' => $paid,
                'remaining' => $remaining,
                'status' => $paid >= $due ? __('messages.paid') : ($paid > 0 ? __('messages.partial') : __('messages.unpaid')),
            ];
        });
    }
public function destroy(Payment $payment)
{
    \App\Models\PaymentLog::create([
        'payment_id' => $payment->id,
        'user_id' => auth()->id(),
        'action' => 'deleted',
        'changes' => [
            'amount' => number_format((float) $payment->amount, 2, '.', ''),
            'month_for' => optional($payment->month_for)->format('Y-m'),
            'payment_date' => optional($payment->payment_date)->format('Y-m-d'),
            'notes' => $payment->notes,
            'method' => $payment->method,
            'deleted_at' => now()->format('Y-m-d H:i:s'),
        ],
    ]);

    $payment->delete();

    return redirect()->route('admin.payments.index')->with('success', __('messages.payment_deleted_successfully'));
}


public function logs(Payment $payment)
{
    $logs = $payment->logs()->with('user')->latest()->get();
    return view('admin.payments.logs', compact('payment', 'logs'));
}
public function logsIndex()
{
    $logs = \App\Models\PaymentLog::with([
        'user',
        'payment' => fn($query) => $query->withTrashed()
    ])
    ->orderByDesc('created_at')
    ->get();

    return view('admin.payments.logs_index', compact('logs'));
}


}
