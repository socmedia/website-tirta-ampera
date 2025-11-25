<div class="flex flex-col" x-data="{
    tabs: @entangle('tabs'),
    active: @entangle('type'),
    slider: @entangle('slider'),
    showSlider: false,
    removeModal: false
}">
    <div class="">
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Sliders
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage sliders, edit and more.
                </p>
            </div>
            @can('create-slider')
                <a class="btn solid-primary whitespace-nowrap" href="{{ route('panel.web.slider.create') }}" wire:navigate>
                    <i class="bx bx-plus"></i>
                    Add Slider
                </a>
            @endcan
        </div>
        <div class="card">
            <div
                 class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 p-4 pb-0 dark:border-neutral-700">
                <nav class="flex gap-1 overflow-auto" role="tablist" aria-label="Tabs">
                    <template x-for="(tab, index) in tabs" :key="index">
                        <button class="tab-button" type="button" role="tab" :aria-controls="tab.value"
                                x-on:click="active = tab.value; $wire.set('type', tab.value)"
                                :class="active === tab.value ? 'tab-active' : 'tab-inactive'"
                                :aria-selected="active === tab.value">
                            <span x-text="tab.label"></span>
                            <span class="tab-count" x-show="tab.count !== undefined" x-text="`(${tab.count})`"></span>
                        </button>
                    </template>
                </nav>
                <div class="ml-auto inline-flex max-w-lg items-center gap-4 pb-4">
                    <x-panel::ui.forms.search />
                    <!-- Locales dropdown removed -->
                </div>
            </div>
            @if (!$data->isEmpty())
                <x-panel::ui.table :sort="$sort" :order="$order" :sortable="true">
                    @foreach ($data as $row)
                        <tr wire:sortable.item="{{ $row->id }}" wire:key="slider-{{ $row->id }}">
                            <td>
                                <div class="min-w-sm flex items-center gap-3">
                                    <img class="w-36 rounded border border-gray-200 object-cover dark:border-neutral-700"
                                         src="{{ $row->thumbnail }}"
                                         alt="{{ $row->heading ?? ($row->title ?? 'Slider Image') }}"
                                         style="aspect-ratio: {{ $row->aspect_ratio }}">
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-600 dark:text-neutral-400">
                                            {{ $row->sub_heading }}
                                        </p>
                                        <h3 class="text-left text-lg font-medium text-gray-800 dark:text-neutral-200">
                                            {{ $row->heading }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-neutral-400">
                                            {{ $row->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a class="link-primary" href="{{ $row->button_url }}"
                                   target="_blank">{{ $row->button_text }}</a>
                            </td>
                            <td>
                                {!! $row->status_badge ?? '' !!}
                            </td>
                            <td>{{ $row->readable_created_at }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                                 :id="$row->id"
                                                                 icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                        <!-- Show -->
                                        @can('view-slider')
                                            <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                       x-on:click="close(); showSlider = true; $wire.showSlider('{{ $row->id }}')">
                                                <i class='bx bx-eye'></i> Show
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                        <!-- Edit -->
                                        @can('update-slider')
                                            <x-panel::ui.dropdown.item href="{{ route('panel.web.slider.edit', $row->id) }}"
                                                                       wire:navigate>
                                                <i class='bx bx-edit'></i> Edit
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                        @can('delete-slider')
                                            <hr class="mx-2 my-0.5 border-b border-gray-100 dark:border-neutral-700">
                                            <!-- Delete -->
                                            <x-panel::ui.dropdown.item class="text-red-600" href="javascript:void(0)"
                                                                       x-on:click="removeModal = true; $wire.set('destroyId', '{{ $row->id }}')">
                                                <i class='bx bx-trash'></i> Delete
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                    </x-panel::ui.dropdown.alpine>
                                    @can('update-slider')
                                        <button class="btn soft-secondary grid size-8 place-items-center p-0 hover:cursor-grab focus:cursor-grabbing dark:text-neutral-400"
                                                type="button" wire:sortable.handle>
                                            <i class="bx bx-categories"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-panel::ui.table>
            @else
                <x-panel::ui.table.empty href="{{ route('panel.web.slider.create') }}" title="There is no data yet."
                                         icon="bx-categories" wire:navigate
                                         description="No sliders have been created yet. Start by adding a new slider to enhance your site."
                                         data="Slider" />
            @endif
        </div>
    </div>
    <!-- Show Slider Dialog -->
    <x-panel::ui.dialog title="Slider Detail" dialog="showSlider" dismiss-action="$wire.dismiss()">
        <div class="space-y-6" :class="{ 'skeleton': !slider }">
            <!-- Slider Header -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <template x-if="slider?.desktop_media_path">
                        <img class="h-12 w-12 rounded object-cover" :src="slider.desktop_media_path"
                             :alt="slider.heading || slider.title">
                    </template>
                    <template x-if="!slider?.desktop_media_path && slider?.icon">
                        <i class="text-2xl" :class="slider.icon"></i>
                    </template>
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100"
                        x-text="slider?.heading || slider?.title"></h2>
                </div>
                <div class="flex gap-2">
                    <span x-html="slider?.status_badge"></span>
                    <span x-html="slider?.featured_badge"></span>
                </div>
            </div>
            <!-- Description Section -->
            <div class="space-y-2">
                <h3 class="font-medium text-zinc-700 dark:text-zinc-300">Description:</h3>
                <template x-if="!slider?.description">
                    <p class="text-sm italic text-zinc-500 dark:text-zinc-400">No description available.</p>
                </template>
                <p class="text-sm text-zinc-600 dark:text-zinc-400" x-show="slider?.description"
                   x-text="slider.description"></p>
            </div>
            <!-- Additional Info -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Type:</span>
                    <p class="text-zinc-600 dark:text-zinc-400" x-text="slider?.type || '-'"></p>
                </div>
                <div>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Sort Order:</span>
                    <p class="text-zinc-600 dark:text-zinc-400" x-text="slider?.sort_order || 'Default'"></p>
                </div>
                <div>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Created:</span>
                    <p class="text-zinc-600 dark:text-zinc-400"
                       x-text="slider?.created_at ? new Date(slider.created_at).toLocaleDateString() : 'N/A'"></p>
                </div>
                <!-- Locale removed -->
            </div>
        </div>
    </x-panel::ui.dialog>
    <x-panel::ui.modal.remove />
</div>
