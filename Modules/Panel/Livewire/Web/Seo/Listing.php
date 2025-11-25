<?php

namespace Modules\Panel\Livewire\Web\Seo;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\Content;
use Modules\Common\Enums\ContentType;
use Modules\Common\Services\ContentService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast, WithFileUploads;

    /**
     * The service instance used for handling content-related logic.
     *
     * @var ContentService
     */
    protected ContentService $contentService;

    /**
     * The selected tab filter (page)
     *
     * @var string|null
     */
    public ?string $tab = null;

    /**
     * The selected section filter (section within tab)
     *
     * @var string|null
     */
    public ?string $section = null;

    /**
     * The list of tabs filter (pages), each with nested sections
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * Edit mode state for the SEO dialog/modal.
     *
     * @var bool
     */
    public bool $editMode = false;

    /**
     * The form data for SEO.
     *
     * @var array
     */
    public array $form = [
        'title' => '',
        'description' => '',
        'keywords' => '',
        'image' => '',
    ];

    /**
     * The current content item (SEO entity).
     *
     * @var mixed|null
     */
    public $seoContent = null;

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'editSeo' => 'enableEditMode',
    ];

    /**
     * The component query string
     *
     * @var array
     */
    protected $queryString = [
        'search',
        'tab',
        'section',
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the content service and initializes the tab tabs and sections.
     *
     * @param ContentService $contentService The service for handling content operations
     * @return void
     */
    public function mount(ContentService $contentService)
    {
        $this->contentService = $contentService;
        $this->editMode = false;
        $this->handleTabsAndSections();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the content service.
     *
     * @param ContentService $contentService The service for handling content operations
     * @return void
     */
    public function hydrate(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get the tabs and sections, and set the current tab and section.
     *
     * @return void
     */
    public function handleTabsAndSections()
    {
        $type = ContentType::SEO->value;
        // Tabs are pages, each with nested sections
        $tabs = $this->contentService->getTabs(type: $type, onlyPage: true);

        $this->tabs = collect($tabs)
            ->map(function ($tabItem) {
                $item = [
                    'label' => str_replace(['_', '-'], [' ', ' - '], $tabItem['label']),
                    'icon' => null,
                    'value' => $tabItem['value'],
                    'count' => $tabItem['count'] ?? null,
                    'children' => [],
                ];
                if (!empty($tabItem['sections'])) {
                    $item['children'] = collect($tabItem['sections'])
                        ->map(function ($sectionItem) use ($tabItem) {
                            return [
                                'label' => str_replace(['_', '-'], [' ', ' - '], $sectionItem['label']),
                                'icon' => null,
                                'value' => $sectionItem['value'],
                                'count' => $sectionItem['count'] ?? null,
                                'children' => [],
                            ];
                        })
                        ->toArray();
                }
                return $item;
            })
            ->toArray();

        // Set current tab
        $this->tab = $this->tab ?: $this->tabs[0]['value'] ?? null;

        // Find the first section for the current tab value
        if (!$this->section) {
            $currentTabKey = array_search($this->tab, array_column($this->tabs, 'value'));
            $this->section = $this->tabs[$currentTabKey]['children'][0]['value'] ?? null;
        }
    }

    /**
     * Reset pagination when search or filters change.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (!in_array($property, ['destroyId', 'checks', 'checkAll'])) {
            $this->resetPage();
        }

        if ($property == 'tab') {
            $this->handleTabsAndSections();
        }
    }

    /**
     * Enable edit mode and load SEO content data into form.
     * This will find the current content (for the chosen tab/section), and fill form for editing.
     */
    public function enableEditMode()
    {
        $this->editMode = true;

        $content = $this->findSeoContent();
        $this->seoContent = $content;

        // Fill form with content data, handle if properties may be missing
        $this->form['title'] = $content['title']->value ?? '';
        $this->form['description'] = $content['description']->value ?? '';
        $this->form['keywords'] = $content['keywords']->value ?? '';
        $this->form['image'] = $content['image']->value ?? '';
    }

    /**
     * Handle the submission of SEO settings (update or create).
     *
     * @return void
     */
    public function handleSeoSubmit()
    {
        $this->validate([
            'form.title' => 'nullable|string|max:255',
            'form.description' => 'nullable|string|max:1000',
            'form.keywords' => 'nullable|string|max:255',
            'form.image' => 'nullable|sometimes|file|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        try {

            // Save the individual SEO fields by section key
            foreach (
                [
                    // 'title', 'description', 'keywords',
                    'image'
                ] as $field
            ) {
                $this->contentService->update(
                    $this->seoContent[$field]->id,
                    [
                        'value' => $this->form[$field],
                    ]
                );
            }

            $this->notifySuccess('SEO settings saved successfully.');
            $this->dismiss();
        } catch (\Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Delete all content for a given page tab with type SEO.
     * Called when user confirms remove on the UI.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                throw new Exception('No item specified for deletion.');
            }

            // Use the content service method to delete all SEO content for the page
            $this->contentService->deleteSeoByPage($this->destroyId);

            $this->notifySuccess('SEO content for page deleted successfully.');
            $this->destroyId = null;
            $this->handleTabsAndSections();
            $this->dispatch('refresh');
        } catch (\Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Find the current SEO content for the selected tab/section.
     *
     * @return array
     */
    public function findSeoContent()
    {
        // Normally this might want to get by ID or some key, here mimic handleListing logic
        $filters = [
            'keyword' => $this->search ?? null,
            'sort' => $this->sort ?? null,
            'order' => $this->order ?? null,
            'page' => $this->tab,
            'section' => $this->section,
            'type' => ContentType::SEO,
        ];
        $items = $this->contentService->listing($filters);

        $out = [
            'image' => $items->where('section', 'image')->first(),
            'keywords' => $items->where('section', 'keywords')->first(),
            'title' => $items->where('section', 'title')->first(),
            'description' => $items->where('section', 'description')->first(),
        ];

        return $out;
    }

    /**
     * Dismiss and reset edit mode/modal and form.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->editMode = false;
        $this->reset('form');
        $this->js('editModal = false');
    }

    /**
     * Handle the listing of content with search, sort, section, and pagination.
     *
     * @return array
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search ?? null,
            'sort' => $this->sort ?? null,
            'order' => $this->order ?? null,
            'page' => $this->tab,
            'section' => $this->section,
            'type' => ContentType::SEO,
        ];

        $items = $this->contentService->listing($filters);

        $data = [
            'image' => null,
            'keywords' => null,
            'title' => null,
            'description' => null,
        ];

        foreach ($data as $i => $item) {
            $data[$i] = $items->where('section', $i)->first();
        }

        return collect($data);
    }

    public function render()
    {
        return view('panel::livewire.web.seo.listing', [
            'data' => $this->handleListing(),
            'editMode' => $this->editMode,
        ]);
    }
}
