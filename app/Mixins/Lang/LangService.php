<?php

namespace App\Mixins\Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class LangService
{
    /**
     * Get the content of a language file.
     *
     * @param string $language
     * @param string|null $file
     * @return array|string
     */
    public function getLangFileContent($language, $file = null)
    {
        $language = mb_strtolower($language);
        $langPath = lang_path($language);

        // Check if specific file is requested
        if ($file) {
            $filePath = $langPath . DIRECTORY_SEPARATOR . "{$file}.php";
            
            // Check if the file exists
            if (File::exists($filePath)) {
                return include $filePath;
            } else {
                Log::warning("Language file not found: $filePath");
                return "File not found";
            }
        } else {
            // If no specific file is requested, return all files in the folder
            $files = File::files($langPath);
            $content = [];

            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $content[$fileName] = include $file;
            }

            return $content;
        }
    }
}
