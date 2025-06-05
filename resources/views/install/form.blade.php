<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تثبيت النظام</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-10 px-4">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">تثبيت النظام</h1>
        
        <form action="{{ route('install.submit') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-1">اسم المدير</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">البريد الإلكتروني</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
    <label class="block mb-1">تأكيد كلمة المرور</label>
    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
</div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">تثبيت</button>
        </form>
    </div>
</body>
</html>
