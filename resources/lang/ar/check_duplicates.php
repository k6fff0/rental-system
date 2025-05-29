<?php

$file = __DIR__ . '/messages.php';
$lines = file($file);

$keys = [];
$duplicates = [];

foreach ($lines as $line) {
    if (preg_match("/'([^']+)'\\s*=>/", $line, $matches)) {
        $key = $matches[1];
        if (isset($keys[$key])) {
            $duplicates[] = $key;
        } else {
            $keys[$key] = true;
        }
    }
}

if (count($duplicates)) {
    echo "🔁 المفاتيح المكررة:\n";
    foreach ($duplicates as $dup) {
        echo "- $dup\n";
    }
} else {
    echo "✅ لا توجد مفاتيح مكررة.\n";
}
