<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlyDueExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $month;

    public function __construct($data, $month)
    {
        $this->data = $data;
        $this->month = $month;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            __('messages.tenant'),
            __('messages.contract_code'),
            __('messages.building'),
            __('messages.unit'),
            __('messages.due_amount'),
            __('messages.paid_amount'),
            __('messages.remaining_amount'),
            __('messages.payment_status'),
        ];
    }
}
