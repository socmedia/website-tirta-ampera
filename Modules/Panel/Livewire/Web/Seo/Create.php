<?php

namespace Modules\Panel\Livewire\Web\Seo;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Livewire\WithFileUploads;
use Modules\Common\Enums\ContentType;
use Modules\Common\Enums\InputType;
use Modules\Common\Services\ContentService;

class Create extends Component
{
    use WithFileUploads, WithToast, FileService, FileService;

    /**
     * The service instance used for handling seo-related logic.
     *
     * @var ContentService
     */
    protected ContentService $contentService;

    /**
     * The base form data for creating new SEO content.
     * Each field (title, description, keywords, image) will be submitted separately.
     *
     * @var array
     */
    public array $form = [
        'page' => '',
        // No section for SEO generally
        // Section can be extended if needed
        'title' => '',
        'description' => '',
        'keywords' => '',
        'image' => null, // For file upload
    ];

    /**
     * Mount the component and inject the ContentService.
     *
     * @param ContentService $contentService
     * @return void
     */
    public function mount(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the content service.
     *
     * @param ContentService $contentService
     * @return void
     */
    public function hydrate(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Livewire hook: called when any property on $form is updated.
     *
     * @param mixed $value
     * @param string $property
     * @return void
     */
    public function updatedForm($value, $property)
    {
        // Format page name to slug when changed
        if ($property === 'page') {
            $this->form['page'] = str($value)->slug('_')->toString();
        }
    }

    /**
     * Handle the creation of new SEO: creates data for image, title, description, and keywords,
     * with output matching Listing usage structure.
     *
     * @return void
     */
    public function handleSubmit()
    {
        // Validate form data
        $validated = $this->validate([
            'form.page' => 'required|string|min:1|max:255',
            'form.title' => 'nullable|string|max:255',
            'form.description' => 'nullable|string|max:1000',
            'form.keywords' => 'nullable|string|max:255',
            'form.image' => 'nullable|sometimes|file|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ], [], [
            'form.page' => 'Page',
            'form.title' => 'SEO Title',
            'form.description' => 'SEO Description',
            'form.keywords' => 'SEO Keywords',
            'form.image' => 'SEO Image',
        ]);

        try {
            // The meta field is null as in the output sample
            $sections = [
                'title' => [
                    'input_type' => InputType::INPUT_TEXT->value,
                    'name' => 'SEO Title',
                    'section' => 'title',
                    'key' => 'seo.' . $this->form['page'] . '.title',
                    'value' => $this->form['title'],
                ],
                'description' => [
                    'input_type' => 'textarea',
                    'name' => 'SEO Description',
                    'section' => 'description',
                    'key' => 'seo.' . $this->form['page'] . '.description',
                    'value' => $this->form['description'],
                ],
                'keywords' => [
                    'input_type' => InputType::INPUT_TEXT->value,
                    'name' => 'SEO Keywords',
                    'section' => 'keywords',
                    'key' => 'seo.' . $this->form['page'] . '.keywords',
                    'value' => $this->form['keywords'],
                ],
                'image' => [
                    'input_type' => InputType::INPUT_IMAGE->value,
                    'name' => 'SEO Image',
                    'section' => 'image',
                    'key' => 'seo.' . $this->form['page'] . '.image',
                    'value' => '/storage' . $this->storeFile($this->form['image']),
                ],
            ];

            foreach ($sections as $section => $meta) {
                // Only create if value is given (EXCEPT title: allow blank title as valid)
                if ($section === 'title' || !empty($meta['value'])) {
                    $data = [
                        'page' => $this->form['page'],
                        'section' => $section,
                        'type' => ContentType::SEO->value,
                        'input_type' => $meta['input_type'],
                        'name' => $meta['name'],
                        'key' => $meta['key'],
                        'meta' => null,
                        'value' => $meta['value'],
                    ];
                    $this->contentService->create($data);
                }
            }

            $this->notifySuccess('SEO created successfully.');
            $this->reset('form');
        } catch (\Exception $e) {
            info($e);
            $this->notifyError($e);
        }
    }

    public function render()
    {
        return view('panel::livewire.web.seo.create', [
            'inputs' => InputType::cases(),
            'pages' => $this->contentService->getPages(),
        ]);
    }
}
