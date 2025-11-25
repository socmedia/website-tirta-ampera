<?php

namespace Modules\Panel\Livewire\Main\Category;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Exception;
use Modules\Common\Models\Category;
use Modules\Common\Services\CategoryService;
use Modules\Panel\Http\Requests\Main\CreateCategoryRequest;

class Create extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling category logic.
     *
     * @var CategoryService
     */
    protected CategoryService $categoryService;

    /**
     * Form data for category creation
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'group' => '',
        'parent_id' => null,
        'icon' => '',
        'image' => null,
        'status' => true,
        'featured' => false,
        'name' => '',
        'description' => '',
    ];

    /**
     * Listen for events from other components.
     *
     * @var array
     */
    protected $listeners = [
        'setCategoryGroup' => 'setGroupFromEvent',
        'createSubCategory' => 'createSubCategoryEvent',
    ];

    /**
     * Mount the component and inject the CategoryService.
     *
     * @param CategoryService $categoryService
     * @param string|null $group
     * @return void
     */
    public function mount(CategoryService $categoryService, ?string $group = null)
    {
        $this->categoryService = $categoryService;

        // Set group if provided
        if ($group !== null) {
            $this->form['group'] = $group;
        }
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the category service and group.
     *
     * @param CategoryService $categoryService The service for handling category operations
     * @return void
     */
    public function hydrate(CategoryService $categoryService, ?string $group = null)
    {
        $this->categoryService = $categoryService;
        // Optionally re-set group if passed in hydration
        if ($group !== null) {
            $this->form['group'] = $group;
        }
    }

    /**
     * Event handler to set the group from another component.
     *
     * @param string $group
     * @return void
     */
    public function setGroupFromEvent(string $group)
    {
        $this->form['group'] = $group;
    }

    /**
     * Event handler to create a sub category, setting group and parent_id.
     *
     * @param string $group
     * @param int|string|null $parentId
     * @return void
     */
    public function createSubCategoryEvent(string $group, $parentId = null)
    {
        $this->form['group'] = $group;
        $this->form['parent_id'] = $parentId;
    }

    /**
     * Handle form submission and create category or subcategory.
     *
     * @return void
     */
    public function handleCreateCategory()
    {
        $request = new CreateCategoryRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->categoryService->create($data);

            $this->reset('form');

            $this->notifySuccess(__('Category created successfully'));
            $this->dispatch('refresh');

            $this->dismiss();
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Prepare form data for submission
     *
     * @return array
     */
    protected function prepareData(): array
    {
        return $this->form;
    }

    /**
     * Reset the form and close the category creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('form');
        // Or, trigger a Livewire event if your UI listens to it
        $this->js('createModal = false');
    }

    public function render()
    {
        return view('panel::livewire.main.category.create', [
            'categories' => [],
        ]);
    }
}
