<?php

namespace Modules\Panel\Livewire\Acl\Role;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Modules\Core\Models\Role;
use Modules\Core\App\Enums\Guards;
use Modules\Core\Models\Permission;
use Modules\Core\Services\RoleService;
use Modules\Panel\Http\Requests\Acl\CreateRoleRequest;

class Create extends Component
{
    use WithToast;

    /**
     * The service instance used for handling role-related logic.
     *
     * @var RoleService
     */
    protected RoleService $roleService;

    /**
     * Form data for role creation
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'name' => '',
        'guard_name' => '',
        'permissions' => []
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the role service and initializes the guard tabs.
     *
     * @param RoleService $roleService The service for handling role operations
     * @return void
     */
    public function mount(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->loadPermissions();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the role service and guard tabs.
     *
     * @param RoleService $roleService The service for handling role operations
     * @return void
     */
    public function hydrate(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Handle property updates
     *
     * @param string $property The property being updated
     * @param mixed $value The new value
     * @return void
     */
    public function updated(string $property, mixed $value): void
    {
        match (true) {
            $property === 'form.guard_name' => $this->loadPermissions(),
            default => null
        };
    }

    /**
     * Load permissions filtered by selected guard
     *
     * @return void
     */
    public function loadPermissions(): void
    {
        $permissions = Permission::query()
            ->where('guard_name', $this->form['guard_name'])
            ->get();

        $this->form['permissions'] = $this->mapPermissions($permissions);
    }

    /**
     * Map permissions into grouped structure
     *
     * @param \Illuminate\Database\Eloquent\Collection $permissions
     * @return array
     */
    protected function mapPermissions($permissions): array
    {
        // If you have $rolePermissions available in the class, use it; otherwise, default to empty array
        $rolePermissions = $this->rolePermissions ?? [];

        return $permissions->pluck('name')
            ->map(function ($permission) {
                // Extract group as the part after the first dash, or 'others' if not present
                // For 'view-dashboard', group is 'dashboard'
                // For 'create-permission', group is 'permission'
                // For 'view-acl-dashboard', group is 'acl-dashboard'
                $parts = explode('-', $permission, 2);
                $group = isset($parts[1]) ? $parts[1] : 'others';
                return [
                    'group' => $group,
                    'key' => str_replace('.', '+', $permission),
                    'name' => $permission,
                ];
            })
            ->groupBy('group')
            ->map(function ($rows) use ($rolePermissions) {
                $data = [];
                foreach ($rows as $row) {
                    $key = $row['key'];
                    $data[$key] = in_array(str_replace('+', '.', $key), $rolePermissions);
                }
                return [
                    'checked' => !empty($data) && count(array_filter($data)) === count($data),
                    'data' => $data,
                ];
            })
            ->toArray();
    }

    /**
     * Update permissions when guard changes
     *
     * @return void
     */
    public function updatedFormGuardName(): void
    {
        $this->loadPermissions();
    }

    /**
     * Prepare form data for submission
     *
     * @return array
     */
    protected function prepareData(): array
    {
        return [
            'name' => $this->form['name'],
            'guard_name' => $this->form['guard_name'],
            'permissions' => $this->getSelectedPermissions(),
        ];
    }

    /**
     * Get list of selected permissions
     *
     * @return array
     */
    protected function getSelectedPermissions(): array
    {
        return collect($this->form['permissions'])
            ->flatMap(
                fn($group) => collect($group['data'])
                    ->filter()
                    ->keys()
                    ->map(fn($key) => str_replace('+', '.', $key))
            )
            ->toArray();
    }

    /**
     * Handle form submission and role creation
     *
     * @return void
     */
    public function handleSubmit(): void
    {
        try {
            $request = new CreateRoleRequest($this->form);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages()
            );

            $data = $this->prepareData();

            // Use RoleService to create the role
            $this->roleService->create($data);

            $this->reset('form');
            $this->notifySuccess('Role created successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.acl.role.create', [
            'guards' => Guards::cases(),
        ]);
    }
}
