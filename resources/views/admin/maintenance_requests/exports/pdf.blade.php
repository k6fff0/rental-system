<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير أرشيف الصيانة</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">تقرير أرشيف الصيانة</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>المبنى</th>
                <th>الوحدة</th>
                <th>نوع العطل</th>
                <th>الفني</th>
                <th>التاريخ</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->building->name ?? '-' }}</td>
                    <td>{{ $req->unit->unit_number ?? '-' }}</td>
                    <td>{{ $req->subSpecialty->name ?? '-' }}</td>
                    <td>{{ $req->technician->name ?? '-' }}</td>
                    <td>{{ $req->created_at->format('Y-m-d') }}</td>
                    <td>{{ __('messages.' . $req->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
