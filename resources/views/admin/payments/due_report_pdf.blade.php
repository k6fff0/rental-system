<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.monthly_due_report') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>
        📊 {{ __('messages.monthly_due_report_for') }} {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}
    </h2>

    <table>
        <thead>
            <tr>
                <th>{{ __('messages.tenant') }}</th>
                <th>{{ __('messages.contract_code') }}</th>
                <th>{{ __('messages.building') }}</th>
                <th>{{ __('messages.unit') }}</th>
                <th>{{ __('messages.due_amount') }}</th>
                <th>{{ __('messages.paid_amount') }}</th>
                <th>{{ __('messages.remaining_amount') }}</th>
                <th>{{ __('messages.payment_status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['tenant'] }}</td>
                    <td>{{ $row['contract_code'] }}</td>
                    <td>{{ $row['building'] }}</td>
                    <td>{{ $row['unit'] }}</td>
                    <td>{{ number_format($row['due'], 2) }}</td>
                    <td>{{ number_format($row['paid'], 2) }}</td>
                    <td>{{ number_format($row['remaining'], 2) }}</td>
                    <td>{{ $row['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
