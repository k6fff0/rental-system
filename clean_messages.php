<?php

// 🔹 عدل المسار لو ملفك مش هنا
$inputFile = __DIR__ . '/resources/lang/en/messages.php';
$outputFile = __DIR__ . '/resources/lang/en/messages_cleaned.php';

$messages = include $inputFile;

$uniqueMessages = [];
foreach ($messages as $key => $value) {
    if (!isset($uniqueMessages[$key])) {
        $uniqueMessages[$key] = $value;
    }
}

// اكتب الملف الجديد
$content = "<?php\n\nreturn [\n";
foreach ($uniqueMessages as $key => $value) {
    // هنهرب ' داخل القيمة لو موجودة
    $value = str_replace("'", "\\'", $value);
    $content .= "    '{$key}' => '{$value}',\n";
}
$content .= "];\n";

file_put_contents($outputFile, $content);

echo "✅ تم إنشاء ملف نظيف بدون مكررات: {$outputFile}\n";
