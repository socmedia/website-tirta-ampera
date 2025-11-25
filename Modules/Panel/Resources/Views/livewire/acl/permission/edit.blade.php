<div>
    <x-panel::ui.modal title="Update Permission" modal="updatePermission" dismiss-action="$wire.dismiss()">
        <form class="md:min-w-md w-full p-4" wire:submit.prevent="handleSubmit">
            <fieldset class="{{ $permission ?: 'skeleton' }} grid gap-4" wire:loading.class="skeleton"
                      wire:target="handleSubmit,findPermission">
                <x-panel::ui.forms.input type="text" label="Name" wire:model.defer="form.name" />

                <x-panel::ui.forms.select label="Guard" wire:model.defer="form.guard_name">
                    <option value="">Choose Guards</option>
                    @foreach ($guards as $item)
                        <option value="{{ $item->value }}">{{ $item->capitalized() }}</option>
                    @endforeach
                </x-panel::ui.forms.select>

                <div class="flex justify-end gap-2 pt-4">
                    <x-panel::ui.buttons type="button" variant="ghost-white"
                                         x-on:click="updatePermission = false; $wire.dismiss()">
                        Cancel
                    </x-panel::ui.buttons>

                    <x-panel::ui.buttons.submit type="submit" wire:target="handleSubmit">
                        <i class="bx bx-save" wire:loading.class="hidden" wire:target="handleSubmit"></i>
                        Update
                    </x-panel::ui.buttons.submit>
                </div>
            </fieldset>
        </form>
    </x-panel::ui.modal>
</div>
