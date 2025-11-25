<?php

namespace Modules\Panel\Livewire\Acl\Permission;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Modules\Core\App\Enums\Guards;
use Spatie\Permission\Models\Permission;
use Modules\Panel\Http\Requests\Acl\CreatePermissionRequest;
use Modules\Panel\Http\Requests\Acl\UpdatePermissionRequest;

class Edit extends Component
{
    use WithToast;

    /**
     * The permission being edited
     *
     * @var Permission|null
     */
    public ?Permission $permission = null;

    /**
     * Form data for create/edit permission.
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'name' => '',
        'guard_name' => ''
    ];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'find' => 'findPermission'
    ];

    /**
     * Find and initialize the permission data
     *
     * @param int $id
     * @return void
     */
    public function findPermission(int $id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) {
                throw new Exception("Permission with ID {$id} could not be found in the database.");
            }

            $this->initialize($permission);
        } catch (Exception $e) {
            $this->dismiss();
            $this->notifyError($e);
        }
    }

    /**
     * Initialize the component with the given Permission model.
     * Populates the form array with the permission's current data.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission  The Permission model instance to initialize from
     * @return void
     */
    public function initialize(Permission $permission)
    {
        $this->permission = $permission;
        $this->form['name'] = $permission->name;
        $this->form['guard_name'] = $permission->guard_name;
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
        ];
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
            $request = new UpdatePermissionRequest($this->form, $this->permission->id);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages(),
            );

            $data = $this->prepareData();

            $this->permission->update($data);

            $this->dismiss();

            $this->dispatch('refresh');
            $this->notifySuccess('Permission updated successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the permission creation dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('form', 'permission');
        $this->js('updatePermission = false');
    }

    public function render()
    {
        return view('panel::livewire.acl.permission.edit',  [
            'guards' => Guards::cases()
        ]);
    }
}
