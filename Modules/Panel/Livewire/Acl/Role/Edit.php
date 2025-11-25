<?php

namespace Modules\Panel\Livewire\Acl\Role;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Modules\Core\Models\Role;
use Modules\Core\Models\Permission;
use Modules\Core\App\Enums\Guards;
use Modules\Core\Services\RoleService;
use Modules\Panel\Http\Requests\Acl\UpdateRoleRequest;

class Edit extends Component
{
    use WithToast;

    /**
     * The service instance used for handling role-related logic.
     *
     * @var RoleService
     */
    protected RoleService $roleService;

    /**
     * The role being edited
     *
     * @var Role|null
     */
    public ?Role $role = null;

    /**
     * Form data for role editing
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'name' => '',
        'guard_name' => '',
        'permissions' => []
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
     * Initialize the component with role data
     *
     * @param RoleService $roleService The service for handling role operations
     * @param Role $role The role to edit
     * @return void
     */
    public function mount(RoleService $roleService, Role $role): void
    {
        $this->roleService = $roleService;
        $this->initialize($role);
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     *
     * @param RoleService $roleService The service for handling role operations
     * @return void
     */
    public function hydrate(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Initialize the component with the given Role model.
     * Populates the form array with the role's current data.
     *
     * @param  Role  $role  The Role model instance to initialize from
     * @return void
     */
    public function initialize(Role $role)
    {
        $this->role = $role;
        $this->form['name'] = $role->name;
        $this->form['guard_name'] = $role->guard_name;
        $this->loadPermissions();
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
     * Map permissions to grouped format
     *
     * @param \Illuminate\Database\Eloquent\Collection $permissions
     * @return array
     */
    protected function mapPermissions($permissions)
    {
        $rolePermissions = $this->role->permissions->pluck('name')->toArray();

        // Group permissions by the prefix before the first dash (e.g., 'view-dashboard' => 'dashboard')
        return $permissions->pluck('name')
            ->map(function ($permission) {
                // Extract group as the part after the last dash, or the first word after the first dash
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
     * Prepare the data for submission
     *
     * @return array
     */
    protected function prepareData()
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
            ->flatMap(fn($group) => collect($group['data'])->filter()->keys())
            ->map(fn($key) => str_replace('+', '.', $key))
            ->toArray();
    }

    /**
     * Handle the form submission
     *
     * @return void
     */
    public function handleSubmit()
    {
        try {
            // Validate form data using defined rules and custom attributes
            $request = new UpdateRoleRequest($this->form, $this->role->id);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages(),
            );

            $data = $this->prepareData();

            // Use RoleService to update the role
            $role = $this->roleService->update($this->role, $data);

            // Re-init with updated role
            $this->initialize($role);

            $this->notifySuccess('Role updated successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.acl.role.edit', [
            'guards' => Guards::cases()
        ]);
    }
}
