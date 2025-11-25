<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Image') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Manage slider image upload.') }}
                </p>
            </div>

            <div class="col-span-12 space-y-4 md:col-span-8">
                @isset($slider->thumbnail)
                    <div class="mb-2">
                        <div class="mb-1 text-xs text-gray-500">{{ __('Current Image') }}</div>
                        <img class="w-36 rounded border border-gray-200 object-cover dark:border-neutral-700"
                             src="{{ $slider->thumbnail }}" alt="{{ $form['alt'] ?? '' }}"
                             style="aspect-ratio: {{ $slider->aspect_ratio }}"
                             onerror="this.onerror=null;this.src='{{ $slider->thumbnail }}';">
                    </div>
                @endisset
                <livewire:panel::utils.dropzone :rules="['image', 'mimes:png,jpeg', 'max:2048']" :key="'dropzone-thumbnail'" accept="*.png,*.jpg" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Settings') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Control slider status and visibility.') }}
                </p>
            </div>

            <div class="col-span-12 space-y-6 md:col-span-8">
                <div class="max-w-xs">
                    <x-panel::ui.forms.select id="slider_type" label="{{ __('Slider Type') }}" wire:model="form.type">
                        @foreach ($sliderTypes as $type)
                            <option value="{{ $type['value'] }}">
                                @if (!empty($type['icon']))
                                    <i class="{{ $type['icon'] }}"></i>
                                @endif
                                {{ $type['label'] }}
                            </option>
                        @endforeach
                    </x-panel::ui.forms.select>
                </div>
                <div class="flex gap-4">
                    <x-panel::ui.forms.switch wire:model.live="form.status" label="Active" />
                </div>
            </div>

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Content') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Update slider content fields.') }}
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <div class="space-y-4">
                    <x-panel::ui.forms.input id="heading" type="text" label="Heading"
                                             wire:model.lazy="form.heading" placeholder="Enter heading" />
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-panel::ui.forms.input id="sub_heading" type="text" label="Sub heading"
                                                 wire:model.lazy="form.sub_heading" placeholder="Enter sub heading" />
                        <x-panel::ui.forms.input id="alt" type="text" label="Alt Text"
                                                 wire:model.lazy="form.alt" placeholder="Enter alt text" />
                    </div>
                    <x-panel::ui.forms.textarea id="description" type="text" rows="3" label="Description"
                                                wire:model.lazy="form.description" placeholder="Enter description" />
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-panel::ui.forms.input id="button_text" type="text" label="Button Text"
                                                 wire:model.lazy="form.button_text" placeholder="Enter button text" />
                        <x-panel::ui.forms.input id="button_url" type="text" label="Button URL"
                                                 wire:model.lazy="form.button_url" placeholder="Enter URL" />
                    </div>
                </div>
            </div>
            <div class="col-span-12 gap-2 pt-4 text-right">
                <x-panel::ui.buttons.spinner type="submit" variant="solid-primary" wire:target="handleSubmit">
                    Update Slider
                </x-panel::ui.buttons.spinner>
            </div>
        </div>
    </form>
</div>
