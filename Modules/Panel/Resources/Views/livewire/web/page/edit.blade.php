<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">
            {{-- STATIC PAGE INFO --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Static Page Info</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Define the page for this static page.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.page" type="text" label="Page" wire:model.lazy="form.page"
                                                 placeholder="e.g. about, contact" list="static-pages" />
                        <datalist id="static-pages">
                            @foreach ($pages as $page)
                                <option value="{{ $page['value'] }}">
                            @endforeach
                        </datalist>
                    </div>
                </fieldset>
            </div>

            {{-- STATIC PAGE VALUE --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Page Content</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Enter the content for this static page.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-12">
                        <x-panel::ui.forms.input id="form.name" label="Page Name" wire:model.lazy="form.name"
                                                 placeholder="Enter page name" />
                    </div>
                    <div class="sm:col-span-12">
                        <x-panel::utils.editor id="content_editor" type="text" label="Content"
                                               wire:model.lazy="form.value" :value="$form['value'] ?? ''"
                                               placeholder="Enter page content" />
                        @error('form.value')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SUBMIT --}}
            <div class="col-span-12 flex justify-end pt-6">
                <x-panel::ui.buttons.submit wire:target="handleSubmit">
                    <i class="bx bx-save" wire:loading.remove wire:target="handleSubmit"></i>
                    Save Page
                </x-panel::ui.buttons.submit>
            </div>
        </div>
    </form>

    <!-- Delete Static Page Section -->
    <div class="mt-10 max-w-screen-lg border-t border-gray-200 pt-10 dark:border-gray-700" x-data="{ show: false }">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-lg font-semibold text-red-600 dark:text-red-400">Delete Static Page</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Permanently delete this static page and all its associated data.
                </p>
            </div>

            <div class="lg:col-span-7">
                <div class="flex justify-end">
                    <x-panel::ui.buttons type="button" variant="solid-danger" x-on:click="show = !show">
                        Delete Static Page
                    </x-panel::ui.buttons>
                </div>
            </div>
        </div>

        <x-panel::ui.modal title="Delete Static Page">
            <form class="space-y-6 p-6" wire:submit="deleteContent">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Are you sure you want to delete this static page?
                    </h2>
                    <p class="my-2 text-sm text-gray-600 dark:text-neutral-400">
                        This will permanently delete this static page and all its data. This action cannot be undone.
                    </p>
                    <small class="italic text-gray-500">Confirm: {{ $content->key }}</small>
                </div>

                <x-panel::ui.forms.input type="text" label="Page name" placeholder="Enter page name to confirm"
                                         wire:model.lazy="confirmation_key" />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <x-panel::ui.buttons type="button" variant="ghost-white"
                                         x-on:click="show = false; $wire.set('confirmation_key', null)">
                        Cancel
                    </x-panel::ui.buttons>
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-danger" wire:target="deleteContent">
                        Delete Static Page
                    </x-panel::ui.buttons.spinner>
                </div>
            </form>
        </x-panel::ui.modal>
    </div>
</div>
