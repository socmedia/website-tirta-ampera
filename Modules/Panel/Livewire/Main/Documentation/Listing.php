<?php

namespace Modules\Panel\Livewire\Main\Documentation;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Modules\Panel\Enums\Documentation;

class Listing extends Component
{
    /**
     * The documentation type (e.g., code-base, website, etc).
     *
     * @var string
     */
    public string $type;

    /**
     * The documentation file name (without extension).
     *
     * @var string
     */
    public string $fileName;

    /**
     * The full file path to the documentation markdown file.
     *
     * @var string
     */
    public string $filePath;

    /**
     * The content of the documentation file.
     *
     * @var string
     */
    public string $fileContent = '';

    /**
     * All documentation enum cases.
     *
     * @var array
     */
    public array $documentationCases = [];

    /**
     * Child files for the current documentation type.
     *
     * @var array
     */
    public array $childFiles = [];

    /**
     * Mount the component with the given parameters.
     *
     * @param string $type
     * @param string $fileName
     * @param string $filePath
     * @return void
     */
    public function mount($type, $fileName, $filePath)
    {
        $this->type = $type;
        $this->fileName = $fileName;
        $this->filePath = $filePath;

        // Get all documentation enum cases
        $this->documentationCases = Documentation::cases();

        // Get child files for the current documentation type
        $this->childFiles = $this->getChildFiles();
    }

    /**
     * Retrieve the content of the documentation file.
     *
     * @return string
     */
    public function getFileContent()
    {
        if (File::exists($this->filePath)) {
            return File::get($this->filePath);
        }
        return 'Documentation file not found.';
    }

    /**
     * Get child files for the current documentation type.
     *
     * @return array
     */
    public function getChildFiles()
    {
        $childFiles = [];
        $docType = Documentation::tryFrom($this->type);

        if ($docType) {
            $locale = app()->getLocale();
            $fileNames = $docType->fileListing();
            $directory = $docType->getDirectory($locale);

            foreach ($fileNames as $file) {
                $childFiles[] = [
                    'name' => $file['name'],
                    'path' => $directory . DIRECTORY_SEPARATOR . $file['name'] . '.md',
                    'roles' => isset($file['roles']) ? implode('|', $file['roles']) : '',
                ];
            }
        }

        return $childFiles;
    }

    public function render()
    {
        return view('panel::livewire.main.documentation.listing', [
            'content' => $this->getFileContent(),
        ]);
    }
}
