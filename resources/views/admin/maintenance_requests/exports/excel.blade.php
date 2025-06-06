<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تصدير أرشيف الصيانة - Excel</title>
</head>

<body>
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
