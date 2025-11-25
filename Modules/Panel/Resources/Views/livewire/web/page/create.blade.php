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
</div>
