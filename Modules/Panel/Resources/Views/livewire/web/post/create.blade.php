<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Image') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Upload a featured image for the post.') }}
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <livewire:panel::utils.dropzone :rules="['image', 'mimes:png,jpeg', 'max:2048']" :key="'dropzone-thumbnail'" accept="*.png,*.jpg" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Settings') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Set post status, category, and visibility.') }}
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <x-panel::ui.forms.select id="post_category" label="{{ __('Category') }}"
                                                  wire:model="form.category_id">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach ($categories as $category)
                                @if (!$category->childs->isEmpty())
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->childs as $subCategory)
                                            <option value="{{ $subCategory->id }}">
                                                {{ $subCategory->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </x-panel::ui.forms.select>
                    </div>
                    <div>
                        <x-panel::ui.forms.select id="post_type" label="{{ __('Type') }}" wire:model="form.type">
                            <option value="">{{ __('Select Type') }}</option>
                            @foreach ($postTypes as $type)
                                <option value="{{ $type['value'] }}">
                                    {{ $type['label'] }}
                                </option>
                            @endforeach
                        </x-panel::ui.forms.select>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <x-panel::utils.tagify-tag id="post_tags" name="form.tags" label="{{ __('Tags') }}"
                                                   wire:model="form.tags" placeholder="{{ __('Add tags') }}" />
                    </div>
                    <div class="flex gap-4 md:col-span-2">
                        <x-panel::ui.forms.switch wire:model.live="form.status" label="Published" />
                    </div>
                </div>
            </div>

            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ __('Content') }}</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ __('Provide post content.') }}
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <div class="space-y-4">
                    <x-panel::ui.forms.input id="title" type="text" label="Title" wire:model.lazy="form.title"
                                             placeholder="Enter title" />
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-panel::ui.forms.input id="slug" type="text" label="Slug"
                                                 wire:model.lazy="form.slug" placeholder="Enter slug"
                                                 description="A unique, URL-friendly identifier for this post." />
                    </div>
                    <x-panel::ui.forms.input id="subject" type="text" label="Subject"
                                             wire:model.lazy="form.subject" placeholder="Enter subject" />
                    <x-panel::utils.editor id="content" type="text" label="Content" wire:model.lazy="form.content"
                                           :value="$form['content']" placeholder="Enter post content" />
                </div>
            </div>
            <div class="col-span-12 gap-2 pt-4 text-right">
                <x-panel::ui.buttons.spinner type="submit" variant="solid-primary" wire:target="handleSubmit">
                    Create Post
                </x-panel::ui.buttons.spinner>
            </div>
        </div>
    </form>
</div>
