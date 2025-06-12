<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Report</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #999; padding: 8px; font-size: 12px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>💸 المصاريف</h2>
<table>
    <thead>
        <tr>
            <th>السيارة</th>
            <th>النوع</th>
            <th>التاريخ</th>
            <th>التكلفة</th>
            <th>ملاحظات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expenses as $e)
        <tr>
            <td>{{ $e->vehicle->plate_number }}</td>
            <td>{{ $e->expense_type }}</td>
            <td>{{ $e->date }}</td>
            <td>{{ $e->cost }}</td>
            <td>{{ $e->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>🚫 المخالفات</h2>
<table>
    <thead>
        <tr>
            <th>السيارة</th>
            <th>السائق</th>
            <th>النوع</th>
            <th>التاريخ</th>
            <th>الغرامة</th>
            <th>ملاحظات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($violations as $v)
        <tr>
            <td>{{ $v->vehicle->plate_number }}</td>
            <td>{{ $v->user->name ?? '-' }}</td>
            <td>{{ $v->violation_type }}</td>
            <td>{{ $v->date }}</td>
            <td>{{ $v->cost }}</td>
            <td>{{ $v->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
