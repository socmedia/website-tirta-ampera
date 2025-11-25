<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">
            {{-- SEO INFO --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">SEO Info</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Define the page for which you want to set SEO data. Fill title, description, keywords, and image.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.input id="form.page" type="text" label="Page" wire:model.lazy="form.page"
                                                 placeholder="e.g. site, auth" list="seo-pages" />
                        <datalist id="seo-pages">
                            @foreach ($pages as $page)
                                <option value="{{ $page['value'] }}">
                            @endforeach
                        </datalist>
                        @error('form.page')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SEO Title --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">SEO Title</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Add the SEO page title.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-12">
                        <x-panel::ui.forms.input id="form.title" label="SEO Title" wire:model.lazy="form.title"
                                                 placeholder="Enter SEO title" />
                        @error('form.title')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SEO Description --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">SEO Description</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Add the SEO meta description.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-12">
                        <x-panel::ui.forms.textarea id="form.description" label="SEO Description"
                                                    wire:model.lazy="form.description" rows="3"
                                                    placeholder="Enter SEO description" />
                        @error('form.description')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SEO Keywords --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">SEO Keywords</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Provide comma separated keywords for SEO.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-12">
                        <x-panel::ui.forms.input id="form.keywords" label="SEO Keywords" wire:model.lazy="form.keywords"
                                                 placeholder="e.g. shop, books, online" />
                        @error('form.keywords')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SEO Image --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">SEO Image</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Upload an image for sharing and rich results.
                </p>
            </div>
            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6">
                    <div class="sm:col-span-12">
                        @if (!empty($form['image']))
                            <div class="mb-4">
                                @php
                                    $img = $form['image'];
                                    $imgSrc = null;
                                    if (is_object($img) && method_exists($img, 'temporaryUrl')) {
                                        $imgSrc = $img->temporaryUrl();
                                    } elseif (
                                        is_string($img) &&
                                        (filter_var($img, FILTER_VALIDATE_URL) || str_starts_with($img, '/'))
                                    ) {
                                        $imgSrc = $img;
                                    }
                                @endphp
                                @if ($imgSrc)
                                    <img class="h-16 rounded" src="{{ $imgSrc }}" alt="Preview">
                                @endif
                            </div>
                        @endif
                        <button class="btn soft-secondary" type="button"
                                onclick="document.getElementById('form-image').click();">
                            <i class="bx bx-folder-up-arrow"></i>
                            Select Image
                        </button>
                        <input class="form-file absolute h-0 w-0 opacity-0" id="form-image" name="form-image"
                               type="file" tabindex="-1" wire:model="form.image" accept="image/*"
                               placeholder="Upload image">
                        <div wire:loading wire:target="form.image">
                            <span class="text-xs text-gray-500">Uploading...</span>
                        </div>
                        @error('form.image')
                            <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
            </div>

            {{-- SUBMIT --}}
            <div class="col-span-12 flex justify-end pt-6">
                <x-panel::ui.buttons.submit wire:target="handleSubmit">
                    <i class="bx bx-save" wire:loading.remove wire:target="handleSubmit"></i>
                    Save SEO
                </x-panel::ui.buttons.submit>
            </div>
        </div>
    </form>
</div>
