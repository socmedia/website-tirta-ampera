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
                                                 placeholder="e.g. site, auth" list="content-pages" />
                        <datalist id="content-pages">
                            @foreach ($pages as $page)
                                <option value="{{ $page['value'] }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.section" type="text" label="Section"
                                                 wire:model.lazy="form.section" placeholder="e.g. about, faq"
                                                 list="content-sections" />
                        <datalist id="content-sections">
                            @foreach ($sections as $section)
                                <option value="{{ $section['value'] }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.key" type="text" label="Key" wire:model.lazy="form.key"
                                                 placeholder="e.g. about_title" />
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
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.meta" type="text" label="Meta (JSON)"
                                                 wire:model.lazy="form.meta" placeholder='{"max":255}' />
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
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.name" label="Content Name" wire:model.lazy="form.name"
                                                 placeholder="Enter content name" />
                    </div>

                    <div class="sm:col-span-6">
                        @php $valuePath = "form.value"; @endphp

                        @switch($form['input_type'])
                            @case('input:number')
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                       for="form-value">
                                    Content Value
                                </label>
                                <input class="form-input text-right" id="form-value" type="number"
                                       wire:model.lazy="{{ $valuePath }}" placeholder="Enter number" />
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

                                @if (!empty($form['value']))
                                    <div class="mb-4">
                                        @php
                                            $value = $form['value'];
                                            $src = null;
                                            if (is_object($value) && method_exists($value, 'temporaryUrl')) {
                                                $src = $value->temporaryUrl();
                                            } elseif (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                                                $src = $value;
                                            }
                                        @endphp
                                        @if ($src)
                                            <img class="h-16 rounded" src="{{ $src }}" alt="Preview">
                                        @endif
                                    </div>
                                @endif

                                <input class="form-file w-full" id="form-value" name="form-value" type="file"
                                       wire:model="form.value" accept="image/*" placeholder="Upload image">
                                <div wire:loading wire:target="form.value">
                                    <span class="text-xs text-gray-500">Uploading...</span>
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
                                    $name = $form['name'] ?? '';
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

                            @case('editor')
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-neutral-200"
                                       for="form-editor">
                                    Content Value
                                </label>
                                <x-panel::utils.editor id="form-editor" type="text" label="Content Value"
                                                       wire:model.lazy="{{ $valuePath }}" :value="$form['value']"
                                                       placeholder="Enter content." />
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

            {{-- SUBMIT --}}
            <div class="col-span-12 flex justify-end pt-6">
                <x-panel::ui.buttons.submit wire:target="handleSubmit">
                    <i class="bx bx-save" wire:loading.remove wire:target="handleSubmit"></i>
                    Save Content
                </x-panel::ui.buttons.submit>
            </div>
        </div>
    </form>
</div>
