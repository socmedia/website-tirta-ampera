<?php

namespace App\Traits;

trait Cancelable
{
    /**
     * Indicates whether the operation has been canceled.
     *
     * @var bool
     */
    public $isCanceled = false;

    /**
     * Cancels the operation and triggers the necessary actions.
     *
     * @return void
     */
    public function cancel()
    {
        $this->isCanceled = true; // Set the canceled state to true
        $this->onCancel(); // Call the onCancel method for additional actions
        $this->resetLivewireProperties(); // Reset Livewire properties after cancellation
        if (method_exists($this, 'afterCancel')) {
            $this->afterCancel();
        }
    }

    /**
     * Method to be overridden in the class using this trait to define the action on cancel.
     *
     * @return void
     */
    protected function onCancel()
    {
        // Override this method in the class using this trait to define the action on cancel
    }

    /**
     * Checks if the operation has been canceled.
     *
     * @return bool
     */
    public function isCanceled()
    {
        return $this->isCanceled; // Return the canceled state
    }
    /**
     * Resets Livewire properties based on user choice.
     *
     * @return void
     */
    protected function resetLivewireProperties()
    {
        if (!property_exists($this, 'reset_except') || empty($this->reset_except)) {
            return $this->reset();
        }

        foreach ($this->getProperties() as  $property => $value) {
            if (!in_array($property, $this->reset_except) && property_exists($this, $property)) {
                $this->reset($property);
            }
        }
    }

    /**
     * Retrieves all properties of the current object.
     *
     * @return array
     */
    protected function getProperties()
    {
        // Get all properties of the current object and filter out the specified keys
        return array_filter(get_object_vars($this), function ($key) {
            return !in_array($key, [
                '__id',
                '__name',
                'listeners',
                'attributes',
                'withValidatorCallback',
                'rulesFromOutside',
                'messagesFromOutside',
                'validationAttributesFromOutside'
            ]);
        }, ARRAY_FILTER_USE_KEY);
    }
}
