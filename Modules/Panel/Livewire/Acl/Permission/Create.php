<?php

namespace Modules\Panel\Livewire\Acl\Permission;

use App\Traits\WithToast;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Exception;
use Modules\Core\App\Enums\Guards;
use Modules\Panel\Http\Requests\Acl\CreatePermissionRequest;

class Create extends Component
{
    use WithToast;

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * Form data for create permission.
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'name' => '',
        'guard_name' => ''
    ];

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
            $request = new CreatePermissionRequest($this->form);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages(),
            );

            $data = $this->prepareData();

            Permission::create($data);

            $this->dismiss();

            $this->dispatch('refresh');
            $this->notifySuccess('Permission created successfully');
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
        $this->reset('form');
        $this->js('createPermission = false');
    }

    public function render()
    {
        return view('panel::livewire.acl.permission.create', [
            'guards' => Guards::cases()
        ]);
    }
}
