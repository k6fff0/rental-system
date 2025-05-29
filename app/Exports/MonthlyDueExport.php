<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MonthlyDueExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithColumnFormatting
{
    protected $data;
    protected $month;

    public function __construct($data, $month)
    {
        $this->data = is_array($data) ? $data : collect($data)->toArray();
        $this->month = $month;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function map($row): array
    {
        return [
            $row['tenant'],
            $row['contract_code'],
            $row['building'],
            $row['unit'],
            $row['collector'] ?? '—',
            $row['due'],
            $row['paid'],
            $row['remaining'],
            $row['status'],
        ];
    }

    public function headings(): array
    {
        return [
            'المستأجر',
            'كود العقد',
            'المبنى',
            'الوحدة',
            'المحصل',
            'المطلوب',
            'المدفوع',
            'المتبقي',
            'الحالة',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->data) + 1;

        // تنسيق رأس الجدول
        $sheet->getStyle("A1:I1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDEEAF6'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFAAAAAA'],
                ],
            ],
        ]);

        // تنسيق كل الجدول (borders)
        $sheet->getStyle("A2:I{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['argb' => 'FFCCCCCC'],
                ],
            ],
            'alignment' => [
                'horizontal' => 'right',
                'vertical' => 'center',
            ],
        ]);

        // RTL لمحاذاة الأعمدة بالعربي
        $sheet->setRightToLeft(true);
    }
}
