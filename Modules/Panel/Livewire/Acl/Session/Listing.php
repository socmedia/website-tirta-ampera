<?php

namespace Modules\Panel\Livewire\Acl\Session;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Modules\Core\Models\Session;
use Modules\Core\Services\SessionService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling session-related logic.
     *
     * @var SessionService
     */
    protected SessionService $sessionService;

    /**
     * The session being displayed
     *
     * @var array $session
     */
    public array $session;

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        self::TABLE_SORT_ORDER,
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the session service and initializes the guard tabs.
     *
     * @param SessionService $sessionService The service for handling session operations
     * @return void
     */
    public function mount(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
        $this->sort = 'last_activity';
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the session service and guard tabs.
     *
     * @param SessionService $sessionService The service for handling session operations
     * @return void
     */
    public function hydrate(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * Show specific Session.
     */
    public function showSession($id)
    {
        try {
            $session = Session::findOrFail($id);
            $this->session = $session->toArray();
        } catch (Exception $exception) {
            $this->dismiss();
            $this->notifyError($exception);
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
    }

    /**
     * Handle the listing of sessions with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
        ];

        return $this->sessionService->listing($filters, $this->perPage);
    }

    public function render()
    {
        return view('panel::livewire.acl.session.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}