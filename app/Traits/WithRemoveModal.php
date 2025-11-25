<?php

namespace App\Traits;

use Livewire\Component;

trait WithRemoveModal
{
    /**
     * Livewire event listener for the Tailwind Remove Modal Component.
     * This constant represents the event for canceling the modal.
     *
     * @var string
     */
    const CANCEL = 'cancelDestroy';

    /**
     * Livewire event listener for the Tailwind Remove Modal Component.
     * This constant represents the event for destroying an item.
     *
     * @var string
     */
    const DESTROY = 'destroy';

    /**
     * Dispatches the cancel event to close the modal.
     *
     * @return void
     */
    public function cancel()
    {
        $this->dispatch(self::CANCEL);
    }

    /**
     * Resets the modal's state when the cancel button is triggered.
     *
     * @return void
     */
    public function cancelDestroy()
    {
        $this->reset('destroyId');
    }
}
