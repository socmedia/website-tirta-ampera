<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">
            {{-- CONTENT INFO --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Content Info</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Define the page, section, key, and type for this content.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.page" type="text" label="Page" wire:model.lazy="form.page"
                                                 placeholder="e.g. about" />
                    </div>
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.section" type="text" label="Section"
                                                 wire:model.lazy="form.section" placeholder="e.g. hero" />
                    </div>
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.key" type="text" label="Key" wire:model.lazy="form.key"
                                                 placeholder="e.g. title" />
                    </div>
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.select id="form.input_type" label="Input Type"
                                                  wire:model.lazy="form.input_type">
                            <option value="">Select input type</option>
                            @foreach ($inputs as $input)
                                <option value="{{ $input->value }}">{{ $input->label() }}</option>
                            @endforeach
                        </x-panel::ui.forms.select>
                    </div>
                </fieldset>
            </div>

            {{-- CONTENT VALUE --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Content Value</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Enter the value for this content. The input adapts to the selected type.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">

                <div class="col-span-12 md:col-span-8">
                    <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                        {{-- Name --}}
                        <div class="sm:col-span-6">
                            <x-panel::ui.forms.input id="form.name" label="Content Name" wire:model.lazy="form.name"
                                                     placeholder="Enter content name" />
                        </div>
                        {{-- Value --}}
                        <div class="sm:col-span-6">
                            @php $valuePath = "form.value"; @endphp

                            @switch($form['input_type'])
                                @case('input:number')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <input class="form-input text-right" id="form-value" x-mask:dynamic="$money($input)"
                                           x-on:change="$wire.set('{{ $valuePath }}', `${$el.value.replace(/[A-Za-z% ,.]/g, '')}`)"
                                           :value="$wire.get('{{ $valuePath }}')" placeholder="Enter number" />
                                @break

                                @case('textarea')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <textarea class="form-textarea w-full" id="form-value" rows="4" wire:model.lazy="{{ $valuePath }}"
                                              placeholder="Enter text"></textarea>
                                @break

                                @case('input:image')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>

                                    <div class="" x-data="{
                                        showModal: false,
                                        closeModal() { this.showModal = false; }
                                    }" x-on:keydown.window.escape="showModal = false">
                                        @if (!empty($form['value']))
                                            @php
                                                $value = $form['value'];
                                                $src = null;
                                                if (is_object($value) && method_exists($value, 'temporaryUrl')) {
                                                    $src = $value->temporaryUrl();
                                                } elseif (is_string($value)) {
                                                    $src = $value;
                                                }
                                            @endphp
                                            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
                                                 x-show="showModal" x-cloak
                                                 x-transition:enter="transition ease-out duration-150"
                                                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                 x-transition:leave="transition ease-in duration-100"
                                                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                 x-on:click.self="showModal = false">
                                                <div
                                                     class="relative w-9/12 max-w-xs rounded-lg bg-white p-4 shadow-lg dark:bg-neutral-800">
                                                    <button class="absolute right-6 top-6 grid size-6 place-items-center rounded-full bg-white/70 text-gray-500 hover:text-gray-700 dark:hover:text-neutral-200"
                                                            type="button" x-on:click="showModal = false">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                    <div class="flex flex-col items-center">
                                                        @if ($src)
                                                            <img class="w-full rounded" src="{{ $src }}"
                                                                 alt="Preview Large">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <input class="form-file w-full" id="form-value" name="form-value" type="file"
                                               wire:model="{{ $valuePath }}" accept="image/*" placeholder="Upload image">

                                        <button class="text-xs italic text-gray-500 hover:text-gray-700 dark:hover:text-neutral-200"
                                                type="button" wire:loading.class="hidden" wire:target="{{ $valuePath }}"
                                                x-on:click="showModal = true">
                                            Preview image
                                        </button>
                                        <div wire:loading wire:target="{{ $valuePath }}">
                                            <span class="text-xs text-gray-500">Uploading...</span>
                                        </div>
                                    </div>
                                @break

                                @case('input:url')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <input class="form-input w-full" id="form-value" type="url"
                                           wire:model.lazy="{{ $valuePath }}" placeholder="https://example.com">
                                @break

                                @case('input:email')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <input class="form-input w-full" id="form-value" type="email"
                                           wire:model.lazy="{{ $valuePath }}" placeholder="you@example.com">
                                @break

                                @case('json')
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <textarea class="font-mono form-textarea w-full text-xs" id="form-value" rows="6"
                                              wire:model.lazy="{{ $valuePath }}" placeholder="{ \"key\": \"value\" }"></textarea>
                                @break

                                @case('input:checkbox')
                                    @php
                                        $name = $form['name'];
                                    @endphp
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200">
                                        Content Value
                                    </label>
                                    <div class="form-input flex items-center">
                                        <input class="form-checkbox" id="form-checkbox" type="checkbox"
                                               wire:model.lazy="{{ $valuePath }}">
                                        <label class="ml-2 text-sm" for="form-checkbox">
                                            {{ $name ? "Enable $name?" : 'Enable?' }}
                                        </label>
                                    </div>
                                @break

                                @default
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                           for="form-value">
                                        Content Value
                                    </label>
                                    <input class="form-input w-full" id="form-value" type="text"
                                           wire:model.lazy="{{ $valuePath }}" placeholder="Enter value">
                            @endswitch

                            @error($valuePath)
                                <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                    </fieldset>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="col-span-12 flex justify-end gap-3 pt-6">
                {{-- Save Button --}}
                <x-panel::ui.buttons.submit wire:target="handleSubmit">
                    <i class="bx bx-save" wire:loading.remove wire:target="handleSubmit"></i>
                    Save Content
                </x-panel::ui.buttons.submit>
            </div>
        </div>
    </form>

    <!-- Delete Content Section -->
    <div class="mt-10 max-w-screen-lg border-t border-gray-200 pt-10 dark:border-gray-700" x-data="{ show: false }">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-lg font-semibold text-red-600 dark:text-red-400">Delete Content</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Permanently delete this content and all its associated data.
                </p>
            </div>

            <div class="lg:col-span-7">
                <div class="flex justify-end">
                    <x-panel::ui.buttons type="button" variant="solid-danger" x-on:click="show = !show">
                        Delete Content
                    </x-panel::ui.buttons>
                </div>
            </div>
        </div>

        <x-panel::ui.modal title="Delete Content">
            <form class="space-y-6 p-6" wire:submit="deleteContent">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Are you sure you want to delete this content?
                    </h2>
                    <p class="my-2 text-sm text-gray-600 dark:text-neutral-400">
                        This will permanently delete this content and all its data. This action cannot be undone.
                    </p>
                    <small class="italic text-gray-500">Confirm: {{ $content->key }}</small>
                </div>

                <x-panel::ui.forms.input type="text" label="Content key"
                                         placeholder="Enter content key to confirm"
                                         wire:model.lazy="confirmation_key" />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <x-panel::ui.buttons type="button" variant="ghost-white"
                                         x-on:click="show = false; $wire.set('confirmation_key', null)">
                        Cancel
                    </x-panel::ui.buttons>
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-danger" wire:target="deleteContent">
                        Delete Content
                    </x-panel::ui.buttons.spinner>
                </div>
            </form>
        </x-panel::ui.modal>
    </div>

</div>
