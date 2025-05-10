<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class LangTranslateCommand extends Command
{
    protected $signature = 'lang:translate {fromLang} {toLang}';

    protected $description = 'Translate Laravel language file from one language to another using LibreTranslate API';

    public function handle()
    {
        $from = $this->argument('fromLang');
        $to = $this->argument('toLang');

        $sourcePath = base_path("resources/lang/{$from}/messages.php");
        $targetPath = base_path("resources/lang/{$to}/messages.php");

        if (!File::exists($sourcePath)) {
            $this->error("Source file not found: {$sourcePath}");
            return 1;
        }

        $messages = include $sourcePath;
        $translated = [];

        $this->info("Translating from [$from] to [$to]...");

        foreach ($messages as $key => $value) {
            if (is_array($value)) {
                $this->warn("Skipping nested array for key: $key");
                $translated[$key] = $value;
                continue;
            }

            $this->line("Translating [$key] => $value");

            $response = Http::asForm()->timeout(20)->post('https://libretranslate.de/translate', [
                'q' => $value,
                'source' => $from,
                'target' => $to,
                'format' => 'text',
            ]);

            if ($response->ok()) {
                $translated[$key] = $response->json('translatedText');
            } else {
                $this->error("Failed to translate key [$key]");
                $translated[$key] = $value; // fallback
            }
        }

        // تحويل إلى PHP file
        $output = "<?php\n\nreturn [\n";
        foreach ($translated as $key => $value) {
            $output .= "    '" . addslashes($key) . "' => '" . addslashes($value) . "',\n";
        }
        $output .= "];\n";

        File::ensureDirectoryExists(dirname($targetPath));
        File::put($targetPath, $output);

        $this->info("Translation complete. Saved to: {$targetPath}");
        return 0;
    }
}
