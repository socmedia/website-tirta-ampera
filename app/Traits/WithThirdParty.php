<?php

namespace App\Traits;

trait WithThirdParty
{
    /**
     * Livewire event name for Tagify component updates.
     *
     * @var string
     */
    const UPDATED_TAGIFY = 'handleTagifyUpdate';

    /**
     * Livewire event name for Editor component updates.
     *
     * @var string
     */
    const UPDATED_EDITOR = 'updatedEditor';

    /**
     * Livewire event name for Cropper component updates.
     *
     * @var string
     */
    const UPDATED_CROPPER = 'updatedCropper';

    /**
     * Livewire event name for Filepond component updates.
     *
     * @var string
     */
    const UPDATED_FILEPOND = 'updatedFilepond';

    /**
     * Livewire event name for Dropzone component updates.
     *
     * @var string
     */
    const UPDATED_DROPZONE = 'updatedDropzone';

    /**
     * Livewire event name for DaterangePicker component updates.
     *
     * @var string
     */
    const UPDATED_DATERANGEPICKER = 'updatedDaterangePicker';

    /**
     * Dispatches an event to reset third-party component states.
     *
     * @return void
     */
    public function resetThirdParty()
    {
        $this->dispatch('resetThirdParty');
    }
}