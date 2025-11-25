<?php

namespace Modules\Panel\Livewire\Web\Content;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Modules\Common\Services\ContentService;
use Modules\Common\Enums\ContentType;

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
     * The table columns definition.
     *
     * @var array
     */
    public array $columns = [
        [
            'name' => 'name',
            'label' => 'Name',
            'sortable' => false,
        ],
        [
            'name' => 'created_at',
            'label' => 'Created',
            'sortable' => false,
        ],
        [
            'name' => 'actions',
            'label' => 'Actions',
            'sortable' => false,
        ],
    ];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
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
        $this->handleTabsAndSections();
        // Removed: $this->handleListing();
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
        $type = ContentType::CONTENT->value;
        // Tabs are pages, each with nested sections
        $tabs = $this->contentService->getTabs(type: $type);
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

        if ($property == 'tab' || $property == 'type') {
            $this->handleTabsAndSections();
        }

        // Removed: $this->handleListing();
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
            'type' => ContentType::CONTENT,
        ];

        return $this->contentService->listing($filters);
    }

    public function render()
    {
        return view('panel::livewire.web.content.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}
