<?php

$path = __DIR__ . '/messages.php';
$data = include $path;

$cleaned = [];
$seen = [];

foreach ($data as $key => $value) {
    if (!isset($seen[$key])) {
        $cleaned[$key] = $value;
        $seen[$key] = true;
    }
}

ksort($cleaned); // اختياري: ترتيب أبجدي

$output = "<?php\n\nreturn [\n";
foreach ($cleaned as $key => $value) {
    $escapedValue = addslashes($value);
    $output .= "    '$key' => '$escapedValue',\n";
}
$output .= "];\n";

file_put_contents($path, $output);

echo "✅ تم حذف التكرارات من ملف اللغة بنجاح!\n";
