<?php

namespace Modules\Panel\Livewire\Web\ContactMessage;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Modules\Common\Models\ContactMessage;
use Modules\Common\Exports\ContactMessageExport;
use Modules\Common\Services\ContactMessageService;
use Modules\Common\Transformers\TransformerResult;

class Listing extends Component
{
    use WithPagination, WithToast, WithTable;

    /**
     * The service instance used for handling contact message logic.
     *
     * @var ContactMessageService
     */
    protected ContactMessageService $contactMessageService;

    /**
     * The TansformerResult model instance.
     *
     * @var ContactMessage|null
     */
    public ContactMessage $selectedMessage;

    /**
     * The selected tab (e.g. 'all', 'seen', 'unseen')
     *
     * @var string|null
     */
    public ?string $tab = 'all';

    /**
     * The available tabs for filtering messages.
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The currently selected message ID.
     *
     * @var int|null
     */
    public $selectedMessageId = null;

    /**
     * The maximum number of items to display per page.
     *
     * @var bool
     */
    public bool $hasMoreItems = true;

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
    ];

    /**
     * Mount the component and inject the ContactMessageService.
     *
     * @param ContactMessageService $contactMessageService
     * @return void
     */
    public function mount(ContactMessageService $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
        $this->tabs = $this->getTabs();
        $this->tab = $this->tab ?? 'all';
    }

    /**
     * Handle component hydration.
     *
     * @param ContactMessageService $contactMessageService
     * @return void
     */
    public function hydrate(ContactMessageService $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
    }

    /**
     * Get the available tabs for filtering messages.
     *
     * @return array
     */
    public function getTabs(): array
    {
        return [
            [
                'label' => 'All',
                'value' => 'all',
            ],
            [
                'label' => 'Unseen',
                'value' => 'unseen',
            ],
            [
                'label' => 'Seen',
                'value' => 'seen',
            ],
        ];
    }

    /**
     * Load more messages by increasing perPage by 5.
     *
     * @return void
     */
    public function loadMore()
    {
        $this->perPage += 5;
    }

    /**
     * Reset pagination when search, tab, or perpage changes.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (in_array($property, ['search', 'tab', 'perpage'])) {
            $this->resetPage();
        }

        if (in_array($property, ['search', 'tab'])) {
            $this->reset('hasMoreItems', 'perPage');
        }

        if ($property == 'selectedMessageId') {
            $this->showMessage();
        }
    }

    /**
     * Build the filters array for listing and export.
     *
     * @return array
     */
    protected function buildFilters(): array
    {
        $filters = [
            'keyword' => $this->search,
            'per_page' => $this->perPage,
        ];

        if ($this->tab === 'unseen') {
            $filters['seen'] = false;
        } elseif ($this->tab === 'seen') {
            $filters['seen'] = true;
        }

        return $filters;
    }

    /**
     * Get the listing of contact messages with filters and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = $this->buildFilters();

        $data = $this->contactMessageService->listing($filters, true);

        if (!$data->hasMorePages()) {
            $this->hasMoreItems = false;
        }

        return $data;
    }

    /**
     * Mark a contact message as seen.
     *
     * @param int $id
     * @return void
     */
    public function markAsSeen($id)
    {
        try {
            $this->contactMessageService->markAsSeen($id, auth()?->id());
            $this->dispatch('refresh');
            $this->showMessage();
            $this->notifySuccess('Message marked as seen successfully.');
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Mark a contact message as unseen.
     *
     * @param int $id
     * @return void
     */
    public function markAsUnseen($id)
    {
        try {
            $this->contactMessageService->markAsUnseen($id);
            $this->dispatch('refresh');
            $this->showMessage();
            $this->notifySuccess('Message marked as unseen successfully.');
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Show a specific message by setting the selectedMessageId.
     *
     * @return ContactMessage|null
     */
    public function showMessage()
    {
        if ($this->selectedMessageId) {
            $message = $this->contactMessageService->findById($this->selectedMessageId);
            return $this->selectedMessage = $message;
        }
        return null;
    }

    /**
     * Handle single contact message deletion using ContactMessageService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->contactMessageService->delete($this->destroyId);

            $this->reset('destroyId');
            $this->dismiss();

            $this->notifySuccess('Message deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Export all contact messages data without pagination
     *
     * @return void
     */
    public function export($type = 'xlsx')
    {
        try {
            if (!in_array($type, ['xlsx', 'csv', 'pdf'])) {
                throw new Exception('Invalid export type. Please use "xlsx", "csv", or "pdf".');
            }

            $filename = 'contact_messages_' . strtotime('now') . '_filters_' . implode('_', [
                'tab_' . ($this->tab ?? 'all'),
                'search_' . ($this->search ?? 'none'),
            ]) . '.' . $type;

            // Build base query for contact messages
            $filters = $this->buildFilters();
            // Remove per_page for export, as we want all results
            unset($filters['per_page']);
            $query = $this->contactMessageService->listing($filters, false);

            if ($type === 'pdf') {
                // For PDF, use dompdf or snappy or any PDF export supported by Laravel Excel
                // Maatwebsite\Excel supports PDF via dompdf if installed
                $excel_type = Excel::DOMPDF;
                $InputType = 'application/pdf';
            } else {
                $excel_type = ($type === 'xlsx') ? Excel::XLSX : Excel::CSV;
                $InputType = 'text/' . $type;
            }

            $this->notifySuccess('Export started successfully. You will receive your download shortly.');
            return app('excel')->download(
                new ContactMessageExport($query),
                $filename,
                $excel_type,
                ['Content-Type' => $InputType]
            );
        } catch (Exception $exception) {
            return $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the post creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('selectedMessage', 'selectedMessageId');
        $this->js('sidebarOpen: true');
    }

    public function render()
    {
        return view('panel::livewire.web.contact-message.listing', [
            'messages' => $this->handleListing(),
        ]);
    }
}
