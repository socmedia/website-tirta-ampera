<div x-data=" {
     editModal: false,
     removeModal: false
 };">
    <div
         class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                SEO
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Manage SEO settings, edit and more.
            </p>
        </div>
        @can('create-seo')
            <a class="btn solid-primary whitespace-nowrap" href="{{ route('panel.web.seo.create') }}" wire:navigate>
                <i class="bx bx-plus"></i>
                Add SEO
            </a>
        @endcan
    </div>
    <div class="grid grid-cols-1 gap-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <x-panel::ui.treeview :items="$tabs" :levels="['tab']" :selected="[$tab]" />
            </div>
            <div class="mx-auto w-full max-w-xl space-y-6 md:col-span-6 xl:col-span-4">
                @if (!$data->isEmpty())
                    <div class="card gap-4 p-4">
                        <div class="mb-3 flex w-full cursor-pointer flex-col items-center" wire:click="enableEditMode"
                             x-on:click="editModal = true">
                            {{-- Image (not editable inline for now) --}}
                            @if (isset($data['image']) && $data['image'])
                                <div
                                     class="mb-2 flex w-full flex-shrink-0 items-center justify-center overflow-hidden rounded border border-gray-200 bg-gray-50 dark:border-neutral-700">
                                    <img class="h-full w-full object-contain" src="{{ $data['image']->value }}"
                                         alt="SEO Image" />
                                </div>
                            @else
                                <div
                                     class="mb-2 flex h-20 w-20 flex-shrink-0 items-center justify-center rounded bg-gray-100 text-gray-300 dark:bg-neutral-800">
                                    <i class="bx bx-image text-3xl"></i>
                                </div>
                            @endif
                            <div class="flex w-full flex-col items-start overflow-hidden">
                                {{-- TITLE --}}
                                <div class="w-full text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                    <span>{{ $data['title']->value ?? '-' }}</span>
                                </div>
                                {{-- DESCRIPTION --}}
                                <div class="mt-1 w-full text-sm text-gray-600 dark:text-neutral-400">
                                    <span>{{ $data['description']->value ?? '-' }}</span>
                                </div>
                                {{-- KEYWORDS --}}
                                <div class="mt-2 w-full text-xs">
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">Keywords:</span>
                                    <span
                                          class="text-gray-700 dark:text-neutral-200">{{ $data['keywords']->value ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        @hasanyrole('Developer|Super Admin')
                            <div class="flex items-center gap-2">
                                <x-panel::ui.buttons.remove class="text-sm" :destroyId="$tab" />
                            </div>
                        @endhasanyrole
                    </div>
                @else
                    <div class="card mx-auto max-w-xl">
                        <div class="flex flex-col items-center py-16 text-center">
                            <div class="mb-4 text-[2.5rem] text-gray-300 dark:text-neutral-700">
                                <i class="bx bx-news"></i>
                            </div>
                            <div class="mb-2 text-lg font-semibold text-gray-700 dark:text-neutral-200">
                                There is no SEO data yet.
                            </div>
                            <div class="mb-4 max-w-xs text-sm text-gray-500 dark:text-neutral-400">
                                No SEO settings have been created yet. Start by adding new SEO data to optimize your
                                site.
                            </div>
                            <a class="btn solid-primary" href="{{ route('panel.web.seo.create') }}" wire:navigate>
                                <i class="bx bx-plus"></i>
                                Add SEO
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div>
        <x-panel::ui.modal title="Edit SEO" modal="editModal" dismissAction="$wire.dismiss()">
            <form class="space-y-6 p-6" wire:submit.prevent="handleSeoSubmit">
                <div>
                    <div class="relative mb-4">
                        @if ($form['image'])
                            <div class="card mb-2 aspect-[3/2] h-24 w-auto rounded-md">
                                <img class="h-full w-full cursor-pointer object-cover"
                                     src="@if (is_string($form['image'])) {{ $form['image'] }} @else {{ $form['image']->temporaryUrl() }} @endif"
                                     alt="SEO Image Preview"
                                     onclick="document.getElementById('seo_image_upload').click();">
                            </div>
                        @endif
                        <input class="absolute opacity-0" id="seo_image_upload" type="file"
                               style="height: 0; width: 0" wire:model.lazy="form.image" accept="image/*"
                               placeholder="Select featured image" />
                        @error('form.image')
                            <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-panel::ui.forms.input id="seo.title" type="text" label="Title"
                                                 wire:model.lazy="form.title" placeholder="SEO title" />
                    </div>
                    <div class="mb-4">
                        <x-panel::ui.forms.textarea id="seo.description" label="Description"
                                                    wire:model.lazy="form.description"
                                                    placeholder="SEO meta description" rows="3" />
                    </div>
                    <div class="mb-4">
                        <x-panel::ui.forms.input id="seo.keywords" type="text" label="Keywords"
                                                 wire:model.lazy="form.keywords"
                                                 placeholder="Comma separated keywords" />
                    </div>
                </div>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <x-panel::ui.buttons type="button" variant="ghost-white" wire:click="dismiss">
                        Cancel
                    </x-panel::ui.buttons>
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-primary" wire:target="handleSeoSubmit">
                        Save
                    </x-panel::ui.buttons.spinner>
                </div>
            </form>
        </x-panel::ui.modal>
    </div>

    <x-panel::ui.modal.remove />
</div>
