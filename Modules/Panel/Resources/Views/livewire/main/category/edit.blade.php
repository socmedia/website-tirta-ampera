<div>
    <x-panel::ui.modal title="Edit Category" modal="editModal" dismissAction="$wire.dismiss()">
        <form class="space-y-6 p-6" wire:submit.prevent="handleSubmit">
            <div>
                <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-panel::ui.forms.input id="name" type="text" label="Name" wire:model.lazy="form.name"
                                             placeholder="Enter category name" />
                </div>
                <div class="mb-4 mt-4">
                    <x-panel::ui.forms.textarea id="description" label="Description" wire:model.lazy="form.description"
                                                placeholder="Short description for this category" rows="3" />
                </div>
            </div>

            <div class="mb-4 flex flex-wrap gap-2 md:gap-4">
                <!-- Active Switch/Checkbox -->
                <x-panel::ui.forms.switch id="edit.status" wire:model.live="form.status" label="Active" />
                <!-- Is Featured Switch/Checkbox -->
                <x-panel::ui.forms.switch id="edit.featured" wire:model.live="form.featured" label="Is Featured" />
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <x-panel::ui.buttons type="button" variant="ghost-white" wire:click="dismiss">
                    Cancel
                </x-panel::ui.buttons>
                <x-panel::ui.buttons.spinner type="submit" variant="solid-primary" wire:target="handleSubmit">
                    Save
                </x-panel::ui.buttons.spinner>
            </div>
        </form>
    </x-panel::ui.modal>
</div>
