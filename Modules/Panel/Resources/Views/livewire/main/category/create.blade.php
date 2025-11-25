<div>
    <x-panel::ui.modal title="Create Category" modal="createModal" dismissAction="$wire.dismiss()">
        <form class="space-y-6 p-6" wire:submit.prevent="handleCreateCategory">
            <div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-panel::ui.forms.input id="name" type="text" label="Name" wire:model.lazy="form.name"
                                             placeholder="Enter category name" />
                </div>
                <div class="mt-4">
                    <x-panel::ui.forms.textarea id="description" label="Description" wire:model.lazy="form.description"
                                                placeholder="Short description for this category" rows="3" />
                </div>
            </div>

            <div class="mb-4 flex flex-wrap gap-2 md:gap-4">
                <!-- Active Switch/Checkbox -->
                <div class="flex items-center space-x-2">
                    <x-panel::ui.forms.switch id="create.status" wire:model.live="form.status" label="Active" />
                </div>
                <!-- Is Featured Switch/Checkbox -->
                <div class="flex items-center space-x-2">
                    <x-panel::ui.forms.switch id="create.featured" wire:model.live="form.featured"
                                              label="Is Featured" />
                </div>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <x-panel::ui.buttons type="button" variant="ghost-white" wire:click="dismiss">
                    Cancel
                </x-panel::ui.buttons>
                <x-panel::ui.buttons.spinner type="submit" variant="solid-primary" wire:target="handleCreateCategory">
                    Create
                </x-panel::ui.buttons.spinner>
            </div>
        </form>
    </x-panel::ui.modal>
</div>
