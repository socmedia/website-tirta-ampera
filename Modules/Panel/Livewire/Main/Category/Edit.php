<?php

namespace Modules\Panel\Livewire\Main\Category;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Livewire\WithFileUploads;
use Modules\Common\Models\Category;
use Modules\Common\Services\CategoryService;
use Modules\Panel\Http\Requests\Main\UpdateCategoryRequest;

class Edit extends Component
{
    use WithFileUploads, WithToast, FileService;

    /**
     * The service instance used for handling category-related logic.
     *
     * @var CategoryService
     */
    protected CategoryService $categoryService;

    /**
     * The category being edited.
     *
     * @var Category|null
     */
    public ?Category $category = null;

    /**
     * The form data for editing a category.
     *
     * @var array
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
        'findCategory' => 'find',
    ];

    /**
     * Mount the component and inject the CategoryService.
     *
     * @param CategoryService $categoryService
     * @param Category|null $category
     * @return void
     */
    public function mount(CategoryService $categoryService, $category = null)
    {
        $this->categoryService = $categoryService;

        if ($category) {
            $this->find($category->id);
        }
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the category service.
     *
     * @param CategoryService $categoryService
     * @return void
     */
    public function hydrate(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Find and load a category by ID.
     *
     * @param int $id
     * @return void
     */
    public function find($id)
    {
        try {
            $category = $this->categoryService->findById($id);

            if (!$category) {
                throw new \Exception('Category not found.');
            }

            $this->category = $category;
            $this->form['group'] = $category->group ?? '';
            $this->form['parent_id'] = $category->parent_id ?? null;
            $this->form['icon'] = $category->icon ?? '';
            $this->form['image'] = $category->image ?? null;
            $this->form['status'] = $category->status ?? true;
            $this->form['featured'] = $category->featured ?? false;
            $this->form['name'] = $category->name ?? '';
            $this->form['description'] = $category->description ?? '';
        } catch (\Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Handle the update of an existing category.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $request = new UpdateCategoryRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->categoryService->update($this->category->id, $data);

            $this->notifySuccess('Category updated successfully.');

            $this->dispatch('refresh');
            $this->dismiss();
        } catch (\Exception $e) {
            info($e);
            $this->notifyError($e);
        }
    }

    /**
     * Delete the current category.
     *
     * @return void
     */
    public function deleteCategory()
    {
        try {
            if (!$this->category) {
                throw new Exception('No category to delete.');
            }

            // Validate confirmation key
            if (
                !$this->confirmation_key ||
                trim($this->confirmation_key) !== ($this->category->name ?? '')
            ) {
                throw new Exception('The confirmation key does not match the category name.');
            }

            $this->categoryService->delete($this->category->id);
            $this->notifySuccess('Category deleted successfully.');
            // Optionally, redirect or emit event to parent
            return $this->redirect(route('panel.main.category.index'), true);
        } catch (\Exception $e) {
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
        $data = $this->form;
        return $data;
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
        $this->js('editModal = false');
    }

    public function render()
    {
        return view('panel::livewire.main.category.edit');
    }
}
