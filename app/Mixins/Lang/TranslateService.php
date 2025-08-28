<?php

namespace App\Mixins\Lang;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TranslateService
{
    private string $translate_from;
    private string $translate_to;
    private $replace_from;
    private bool $isFolder;

    //setters
    public function from(string $from, $isFolder = true, $replaceFrom = null): TranslateService
    {
        Log::info("Setting translation from: $from");

        $this->isFolder = $isFolder;
        $this->replace_from = $replaceFrom;
        $this->translate_from = $from;
        return $this;
    }

    public function to(string $to): TranslateService
    {
        Log::info("Setting translation to: $to");

        $this->translate_to = $to;
        return $this;
    }

    public function translate(): void
    {
        Log::info("Starting translation process...");

        $files = $this->getLocalLangFiles();

        foreach ($files as $file) {
            Log::info("Processing file: " . $file->getRealPath());
            $translatedData = $this->getTranslatedData($file);
            Log::info("Translated content for " . $file->getRealPath() . ": $translatedData");

            $this->filePutContent($translatedData, $file);
        }

        Log::info("Translation process completed.");
    }

    private function getLocalLangFiles(): array
    {
        Log::info("Retrieving local language files...");

        if ($this->isFolder) {
            $this->existsLocalLangDir();
        }

        $this->existsLocalLangFiles();

        return $this->getFiles($this->getTranslateLocalPath());
    }

    private function filePutContent(string $translatedData, string $file): void
    {
        $folderPath = lang_path($this->translate_to);

        $fileName = pathinfo($file, PATHINFO_FILENAME) . '.php';

        Log::info("Preparing to write translated content to: $folderPath/$fileName");

        if (!$this->isFolder) {
            $filePathTmp = explode($this->replace_from, $file);
            if (count($filePathTmp)) {
                $filePathTmp = $filePathTmp[1];

                $folderTmp = explode('/', $filePathTmp);
                unset($folderTmp[count($folderTmp) - 1]);

                $folderTmp = implode('/', $folderTmp);
                $folderPath .= $folderTmp;
            }
        }

        if (!File::isDirectory($folderPath)) {
            Log::info("Directory does not exist. Creating directory: $folderPath");
            File::makeDirectory($folderPath, 0777, true);
        }

        $filePath = $folderPath . DIRECTORY_SEPARATOR . $fileName;
        File::put($filePath, $translatedData);

        Log::info("Translated content written to: $filePath");
    }

    private function getTranslatedData(SplFileInfo $file): string
    {
        Log::info("Fetching data for translation from: " . $file->getRealPath());

        $content = include $file;
        Log::info("Original content from file: " . print_r($content, true));

        $translatedData = var_export($this->translateLangFiles($content), true);
        Log::info("Translated data: $translatedData");

        return $this->addPhpSyntax($translatedData);
    }

    private function setUpGoogleTranslate(): GoogleTranslate
    {
        Log::info("Setting up Google Translate from {$this->translate_from} to {$this->translate_to}");

        $google = new GoogleTranslate();
        return $google->setSource($this->translate_from)
            ->setTarget($this->translate_to);
    }

    private function translateLangFiles(array $content): array
    {
        Log::info("Translating language file content...");

        $google = $this->setUpGoogleTranslate();

        if (!empty($content)) {
            return $this->translateRecursive($content, $google);
        }

        return [];
    }

    private function translateRecursive($content, $google): array
    {
        $trans_data = [];

        foreach ($content as $key => $value) {
            if (!is_array($value)) {
                Log::info("Translating key: $key, value: $value");
                $trans_data[$key] = $google->translate($value);
            } else {
                $trans_data[$key] = $this->translateRecursive($value, $google);
            }
        }

        return $trans_data;
    }

    private function addPhpSyntax(string $translatedData): string
    {
        return '<?php return ' . $translatedData . ';';
    }

    // Exceptions
    private function existsLocalLangDir(): void
    {
        $path = $this->getTranslateLocalPath();

        Log::info("Checking if the local lang directory exists: $path");

        throw_if(
            !File::isDirectory($path),
            ("lang folder $this->translate_from not Exist !" . PHP_EOL . '  Have you run `php artisan lang:publish` command before?')
        );
    }

    private function existsLocalLangFiles(): void
    {
        $files = $this->getFiles($this->getTranslateLocalPath());

        throw_if(empty($files), ("lang files in '$this->translate_from' folder not found !"));
    }

    //helpers
    private function getFiles(string $path = null): array
    {
        if ($this->isFolder) {
            return File::files($path);
        }

        $file = new SplFileInfo($path, '', '');
        return [$file];
    }

    private function getTranslateLocalPath(): string
    {
        return lang_path(DIRECTORY_SEPARATOR . $this->translate_from);
    }
}
