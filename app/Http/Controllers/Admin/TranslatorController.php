<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;  // Correctly import the Log facade

use App\Http\Controllers\Controller;
use App\Mixins\Lang\TranslateService;
use App\Mixins\Lang\LangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslatorController extends Controller
{
protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }
    public function index(Request $request)
    {
        $this->authorize("admin_translator");

        $dir = base_path('lang/en');
        $langFiles = $this->getLangFolderFilesList($dir);

        $data = [
            'pageTitle' => trans('update.translator'),
            'langFiles' => $langFiles
        ];

        return view('admin.translator.index', $data);
    }

    public function translate(Request $request)
    {
        $this->authorize("admin_translator");
        $data = $request->all();

        $validator = Validator::make($data, [
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $language = mb_strtolower($data['language']);
        $error = null;

        $specificFilesPath = [];
        if (!empty($data['specific_file']) and !empty($data['lang_files']) and is_array($data['lang_files'])) {
            $specificFilesPath = $this->getSelectedFilesPath($data['lang_files']);
        }

        try {
            $translateService = (new TranslateService());

            if (count($specificFilesPath)) {
                foreach ($specificFilesPath as $filePath) {
                    $translateService->to($language)->from($filePath, false, 'en')->translate();
                }
            } else {
                $translateService->to($language)->from('en')->translate();
            }
        } catch (\Exception $exception) {
            $error = "Error: " . $exception->getMessage();
        }

        return response()->json([
            'code' => 200,
            'error' => $error,
            'msg' => ' - Finished translation! (go to lang/' . $language . ' folder) ',
        ]);
    }

    private function getSelectedFilesPath($items, $folder = null)
    {
        $filesPath = [];

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $folder .= "/$key";

                $filesPathTmp = $this->getSelectedFilesPath($item, $folder);

                $filesPath = array_merge($filesPath, $filesPathTmp);
            } else {
                $filesPath[] = 'en' . ($folder ? "{$folder}/" : '/') . "{$item}.php";
            }
        }

        return $filesPath;
    }

    private function getLangFolderFilesList($dir)
    {
        $result = [];

        if (is_dir($dir)) {
            // Open the directory
            if ($dh = opendir($dir)) {
                // Read files and directories inside the directory
                while (($file = readdir($dh)) !== false) {
                    // Skip '.' and '..'
                    if ($file != "." && $file != "..") {
                        // Check if it's a directory
                        if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                            $result[$file] = $this->getLangFolderFilesList($dir . DIRECTORY_SEPARATOR . $file);
                        } else {
                            // It's a file
                            $result[] = pathinfo($file, PATHINFO_FILENAME);
                        }
                    }
                }

                // Close the directory
                closedir($dh);
            }
        }

        return $result;
    }
private function getSelectedFilesContent($items, $folder = null)
{
    $filesContent = [];

    foreach ($items as $key => $item) {
        // Log when processing a folder or file
        Log::info("Processing item: $key", ['item' => $item, 'folder' => $folder]);

        if (is_array($item)) {
            $folder .= "/$key";
            Log::info("Entering folder: $folder");

            $filesContentTmp = $this->getSelectedFilesContent($item, $folder);

            // Merge the content of nested files
            $filesContent = array_merge($filesContent, $filesContentTmp);

            Log::info("Merged content from folder: $folder");
        } else {
            $filePath = lang_path("en" . ($folder ? "/$folder" : '') . "/{$item}.php");

            // Log the file path being checked
            Log::info("Checking file: $filePath");

            // Check if the file exists and read its content
            if (File::exists($filePath)) {
                $fileContent = include $filePath;

                // Log the file content (or a portion of it for privacy)
                Log::info("File content loaded", ['file' => $filePath, 'content_preview' => array_slice($fileContent, 0, 5)]); // Preview first 5 items for brevity

                $filesContent[] = [
                    'file' => $filePath,
                    'content' => $fileContent
                ];
            } else {
                // If the file doesn't exist, log it
                Log::warning("File not found: $filePath");
            }
        }
    }

    // Log the final collected content
    Log::info("Returning files content", ['files' => $filesContent]);

    return $filesContent;
}
public function showLangContent()
{
    // Get the language and files parameters from the request
    $file = request()->input('lang_files');
    $specificFile = request()->input('specific_file');
    $language = strtolower(request()->input('language'));

    // Log the full request data for debugging purposes
    Log::info("Show Lang Content Called", [
        'language' => $language,
        'file' => $file,
        'specific_file' => $specificFile,
        'request' => request()->all()
    ]);

    // Ensure $file is always treated as an array
    $file = (array) $file;

    // Initialize the files array
    $files = [];

    // Process the files from the request
    foreach ($file as $key => $value) {
        if (is_array($value)) {
            if (isset($value['pages']) && is_array($value['pages'])) {
                foreach ($value['pages'] as $page) {
                    $files[] = "admin/{$page}";
                }
            }
        } else {
            $files[] = $value;
        }
    }

    // Default to 'home' if no specific file is provided
    $files = $specificFile ? $files : ['home'];

    $langContents = [];

    // Load the language files
    foreach ($files as $fileName) {
        $filePath = lang_path("$language/{$fileName}.php");

        if (file_exists($filePath)) {
            $langContents[$fileName] = include $filePath;
            Log::info("Language Content Loaded: $fileName", ['content' => $langContents[$fileName]]);
        } else {
            Log::warning("Language file not found: $filePath");
        }
    }

    // Return the view with language content and request data
    return view('admin.translator.strings', [
        'langContent' => $langContents,
        'requestData' => request()->all()  // Pass the request data to the view
    ]);
}

public function updateLangContent(Request $request)
{
    // Log the start of the function
    Log::info("Starting updateLangContent function");

    // Get the language, files, and specific file checkbox values from the request
    $file = $request->input('lang_files');
    $specificFile = $request->input('specific_file');
    $language = strtolower($request->input('language'));
    $translations = $request->input('translations');

    Log::info("Received input data", [
        'language' => $language,
        'file' => $file,
        'specific_file' => $specificFile,
        'translations' => $translations,
        'request' => $request->all()
    ]);

    // Ensure $file is always treated as an array
    $file = (array) $file;
    Log::info("File data processed as array", ['file' => $file]);

    // Initialize the files array
    $files = [];
    Log::info("Initialized files array", ['files' => $files]);

    // Loop through the files in the request
    foreach ($file as $key => $value) {
        if (is_array($value)) {
            Log::info("Processing array value in lang_files", ['key' => $key, 'value' => $value]);
            if (isset($value['pages']) && is_array($value['pages'])) {
                foreach ($value['pages'] as $page) {
                    $files[] = "admin/{$page}";
                    Log::info("Added admin page to files array", ['page' => $page]);
                }
            }
        } else {
            $files[] = $value;
            Log::info("Added file to files array", ['value' => $value]);
        }
    }

    // Use specific files if provided, otherwise default to ['home']
    $files = $specificFile ? $files : ['home'];
    Log::info("Final files array", ['files' => $files]);

    // Loop through the files and update the translations
    foreach ($files as $fileName) {
        $filePath = lang_path("$language/{$fileName}.php");
        Log::info("Processing file", ['filePath' => $filePath]);

        if (file_exists($filePath)) {
            Log::info("File exists, including content", ['filePath' => $filePath]);
            $existingContent = include $filePath;

            if (isset($translations[$fileName])) {
                Log::info("Merging existing content with new translations", [
                    'existingContent' => $existingContent,
                    'newTranslations' => $translations[$fileName]
                ]);
                $updatedContent = array_merge($existingContent, $translations[$fileName]);
                file_put_contents($filePath, '<?php return ' . var_export($updatedContent, true) . ';');
                Log::info("Updated file content written successfully", ['filePath' => $filePath, 'content' => $updatedContent]);
            }
        } else {
            Log::warning("Language file not found for update", ['filePath' => $filePath]);
        }
    }

    // Log the completion of the process
    Log::info("Language content update process completed");

    // Return a success status
    return response()->json(['status' => 'success', 'message' => 'Language content updated successfully']);
}








}
