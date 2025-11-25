<?php

namespace App\Traits;

trait WithModal
{
    /**
     * Livewire event listener for the Tailwind Modal Component.
     * This constant is used to initialize the modal.
     *
     * @var string
     */
    const INIT_MODAL = 'initModal';

    /**
     * Livewire event listener for the Tailwind Modal Component.
     * This constant is used to close the modal.
     *
     * @var string
     */
    const CLOSE_MODAL = 'closeModal';

    /**
     * Indicates whether the modal is currently loading.
     *
     * @var bool
     */
    public bool $loading = true;

    /**
     * Handles the "initModal" event in the modal component.
     * This method disables the loading state of the modal.
     *
     * @return void
     */
    public function initModal()
    {
        $this->loading = false;
    }

    /**
     * Handles the "closeModal" event in the modal component.
     * This method resets the modal's properties and error bag.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->resetErrorBag();

        if (property_exists($this, 'reset_except')) {
            $this->except($this->reset_except);
        } else {
            $this->reset();
        }

        return $this->dispatch('cancel');
    }
}
