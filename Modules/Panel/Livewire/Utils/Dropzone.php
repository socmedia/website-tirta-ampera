<?php

namespace Modules\Panel\Livewire\Utils;

use App\Traits\WithThirdParty;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Dropzone extends Component
{
    use WithFileUploads, WithThirdParty;

    /**
     * The files managed by the dropzone (selected and/or uploaded).
     *
     * @var array|null
     */
    #[Modelable]
    public ?array $files = [];

    /**
     * The validation rules for file uploads.
     *
     * @var array
     */
    #[Locked]
    public array $rules = [];

    /**
     * The unique identifier for this dropzone instance.
     *
     * @var string
     */
    #[Locked]
    public string $uuid;

    /**
     * The current upload(s) being processed.
     *
     * @var mixed
     */
    public $upload;

    /**
     * The error message for the upload process.
     *
     * @var string
     */
    public $error = '';

    /**
     * Whether multiple files can be uploaded.
     *
     * @var bool
     */
    public bool $multiple = false;

    /**
     * Livewire event name for Dropzone component updates.
     *
     * @var string
     */
    public const UPDATED_DROPZONE = 'updatedDropzone';

    /**
     * Get the validation rules for the upload.
     *
     * @return array
     */
    public function rules(): array
    {
        $field = $this->multiple ? 'upload.*' : 'upload';

        // If no rules are set, allow any file (prevents 422 Unprocessable Content)
        if (empty($this->rules)) {
            return [
                $field => ['nullable', 'file'],
            ];
        }

        return [
            $field => [...$this->rules],
        ];
    }

    /**
     * Mount the component with initial values.
     *
     * @param array $rules
     * @param bool $multiple
     * @param array $files
     * @return void
     */
    public function mount(array $rules = [], bool $multiple = false, array $files = []): void
    {
        $this->uuid = (string) Str::uuid();
        $this->multiple = $multiple;
        $this->rules = $rules;
        $this->files = $files;
    }

    /**
     * Handle the upload update event.
     *
     * @return void
     */
    public function updatedUpload(): void
    {
        $this->reset('error');

        try {
            $this->validate();
        } catch (ValidationException $e) {
            // If the upload validation fails, dispatch the upload error event
            $this->dispatch("{$this->uuid}:uploadError", $e->getMessage());
            return;
        }

        $uploads = $this->multiple ? $this->upload : [$this->upload];

        // Defensive: filter out null/empty uploads to avoid 422 errors
        $uploads = array_filter((array) $uploads);

        foreach ($uploads as $upload) {
            if ($upload instanceof TemporaryUploadedFile) {
                $this->handleUpload($upload);
            }
        }

        $this->reset('upload');
    }

    /**
     * Handle the uploaded file and dispatch an event with file details.
     *
     * @param TemporaryUploadedFile $file
     * @return void
     */
    public function handleUpload(TemporaryUploadedFile $file): void
    {
        $this->dispatch("{$this->uuid}:fileAdded", [
            'tmpFilename' => $file->getFilename(),
            'name' => $file->getClientOriginalName(),
            'extension' => $file->extension(),
            'path' => $file->path(),
            'temporaryUrl' => $file->isPreviewable() ? $file->temporaryUrl() : null,
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Handle the file added event.
     *
     * @param array $file
     * @return void
     */
    #[On('{uuid}:fileAdded')]
    public function onFileAdded(array $file): void
    {
        $this->files = $this->multiple ? array_merge($this->files ?? [], [$file]) : [$file];
        $this->dispatch(self::UPDATED_DROPZONE, $this->files);
    }

    /**
     * Handle the file removal event.
     *
     * @param string $tmpFilename
     * @return void
     */
    #[On('{uuid}:fileRemoved')]
    public function onFileRemoved(string $tmpFilename): void
    {
        $this->files = array_values(array_filter($this->files ?? [], function ($file) use ($tmpFilename) {
            // Only remove the file from the files array.
            // No need to manually remove from Livewire's temporary upload directory,
            // as files older than 24 hours are cleaned up automatically by Livewire.
            // See: https://livewire.laravel.com/docs/uploads#configuring-automatic-file-cleanup
            return $file['tmpFilename'] !== $tmpFilename;
        }));

        // Dispatch the updatedDropzone event after file removal
        $this->dispatch(self::UPDATED_DROPZONE, $this->files);
    }

    /**
     * Handle the upload error event.
     */
    #[On('{uuid}:uploadError')]
    public function onUploadError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * Handle the resetThirdParty event.
     *
     * This will reset the dropzone state (files, upload, error).
     */
    #[On('resetThirdParty')]
    public function onResetThirdParty(): void
    {
        $this->reset('files', 'upload', 'error');
        $this->dispatch(self::UPDATED_DROPZONE, $this->files);
    }

    /**
     * Retrieve the MIME types from the rules.
     */
    #[Computed]
    public function mimes(): string
    {
        return collect($this->rules)
            ->filter(fn($rule) => str_starts_with($rule, 'mimes:'))
            ->flatMap(fn($rule) => explode(',', substr($rule, strpos($rule, ':') + 1)))
            ->unique()
            ->values()
            ->join(', ');
    }

    /**
     * Get the accepted file extensions based on MIME types.
     */
    #[Computed]
    public function accept(): ?string
    {
        $mimes = $this->mimes;
        return !empty($mimes)
            ? collect(explode(', ', $mimes))->map(fn($mime) => '.' . trim($mime))->implode(',')
            : null;
    }

    /**
     * Get the maximum file size in a human-readable format.
     */
    #[Computed]
    public function maxFileSize(): ?string
    {
        return collect($this->rules)
            ->filter(fn($rule) => str_starts_with($rule, 'max:'))
            ->flatMap(fn($rule) => explode(',', substr($rule, strpos($rule, ':') + 1)))
            ->unique()
            ->values()
            ->first();
    }

    /**
     * Checks if the provided MIME type corresponds to an image extension.
     */
    public function isImageMime($mime): bool
    {
        return in_array(strtolower($mime), ['png', 'gif', 'bmp', 'svg', 'jpeg', 'jpg']);
    }

    public function render()
    {
        return view('panel::livewire.utils.dropzone');
    }
}
