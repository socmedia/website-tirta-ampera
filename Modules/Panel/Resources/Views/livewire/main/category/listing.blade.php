<div class="flex flex-col" x-data="{
    tabs: @entangle('tabs'),
    active: @entangle('status'),
    category: @entangle('category'),
    showCategory: false,
    createModal: false,
    editModal: false,
    removeModal: false
}">
    <div class="">
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Categories
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage categories, edit and more.
                </p>
            </div>

            @can($createPermission)
                <a class="btn solid-primary whitespace-nowrap" href="javascript:void(0)"
                   x-on:click="createModal = true; $wire.dispatch('setCategoryGroup', { group: '{{ $group }}' })">
                    <i class="bx bx-plus"></i>
                    Add Category
                </a>
            @endcan
        </div>

        <div class="card">
            <div
                 class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 p-4 pb-0 dark:border-neutral-700">
                <nav class="flex gap-1 overflow-auto" role="tablist" aria-label="Tabs">
                    <template x-for="(tab, index) in tabs" :key="index">
                        <button class="tab-button" type="button" role="tab" :aria-controls="tab.value"
                                x-on:click="active = tab.value; $wire.set('status', tab.value)"
                                :class="active === tab.value ? 'tab-active' : 'tab-inactive'"
                                :aria-selected="active === tab.value">
                            <span x-text="tab.label"></span>
                            <span class="tab-count" x-show="tab.count !== undefined" x-text="`(${tab.count})`"></span>
                        </button>
                    </template>
                </nav>
                <div class="ml-auto inline-flex max-w-lg items-center gap-4 pb-4">
                    <x-panel::ui.forms.search />
                    <!-- Removed Multilang/Locale Dropdown -->
                </div>
            </div>

            @if (!$data->isEmpty())
                <x-panel::ui.table sort="name" order="asc" :sortable="true">
                    @foreach ($data as $row)
                        <tr
                            @can($updatePermission) wire:sortable.item="{{ $row->id }}" wire:key="category-{{ $row->id }}" @endcan>
                            <td>
                                <div class="flex items-center gap-2">
                                    @if ($row->image_path)
                                        <img class="h-8 w-8 rounded object-cover" src="{{ $row->image_path }}"
                                             alt="{{ $row->name }}">
                                    @elseif($row->icon)
                                        <i class="{{ $row->icon }} text-lg"></i>
                                    @endif
                                    <p>{{ $row->name }}</p>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    {{ $row->description }}</p>
                            </td>
                            <td>
                                {!! $row->status_badge !!}
                            </td>
                            <td>
                                {!! $row->featured_badge !!}
                            </td>
                            <td>{!! $row->readable_created_at !!}</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                                 :id="$row->id"
                                                                 icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                        <!-- Show -->
                                        <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                   x-on:click="close(); showCategory = true; $wire.showCategory('{{ $row->id }}')">
                                            <i class='bx bx-eye'></i> Show
                                        </x-panel::ui.dropdown.item>

                                        @can($updatePermission)
                                            <!-- Edit -->
                                            <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                       x-on:click="close(); editModal = true; $wire.dispatch('findCategory', { id: '{{ $row->id }}' })">
                                                <i class='bx bx-edit'></i> Edit
                                            </x-panel::ui.dropdown.item>
                                        @endcan

                                        @can($deletePermission)
                                            <hr class="mx-2 my-0.5 border-b border-gray-100 dark:border-neutral-700">
                                            <!-- Delete -->
                                            <x-panel::ui.dropdown.item class="text-red-600" href="javascript:void(0)"
                                                                       x-on:click="removeModal = true; $wire.set('destroyId', '{{ $row->id }}')">
                                                <i class='bx bx-trash'></i> Delete
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                    </x-panel::ui.dropdown.alpine>

                                    @can($updatePermission)
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
                <x-panel::ui.table.empty href="javascript:void(0)" title="There is no data yet." icon="bx-categories"
                                         x-on:click="createModal = true; $wire.dispatch('setCategoryGroup', { group: '{{ $group }}' })"
                                         description="No categories have been created yet. Start by adding a new category to organize your content."
                                         data="Category" />
            @endif
        </div>
    </div>

    <!-- Show Category Dialog -->
    <x-panel::ui.dialog title="Category Detail" dialog="showCategory" dismiss-action="$wire.dismiss()">
        <div class="space-y-6" :class="{ 'skeleton': !category }">

            <!-- Category Header -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <template x-if="category?.image_path">
                        <img class="h-12 w-12 rounded object-cover" :src="category.image_path" :alt="category.name">
                    </template>
                    <template x-if="!category?.image_path && category?.icon">
                        <i class="text-2xl" :class="category.icon"></i>
                    </template>
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100" x-text="category?.name"></h2>
                </div>
                <div class="flex gap-2">
                    <span x-html="category?.status_badge"></span>
                    <span x-html="category?.featured_badge"></span>
                </div>
            </div>

            <!-- Description Section -->
            <div class="space-y-2">
                <h3 class="font-medium text-zinc-700 dark:text-zinc-300">Description:</h3>
                <template x-if="!category?.description">
                    <p class="text-sm italic text-zinc-500 dark:text-zinc-400">No description available.</p>
                </template>
                <p class="text-sm text-zinc-600 dark:text-zinc-400" x-show="category?.description"
                   x-text="category.description"></p>
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Sort Order:</span>
                    <p class="text-zinc-600 dark:text-zinc-400" x-text="category?.sort_order || 'Default'"></p>
                </div>
                <div>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Created:</span>
                    <p class="text-zinc-600 dark:text-zinc-400"
                       x-text="category?.created_at ? new Date(category.created_at).toLocaleDateString() : 'N/A'"></p>
                </div>
            </div>

            <!-- Sub Categories Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-medium text-zinc-700 dark:text-zinc-300">Sub Categories</h3>

                    @can($createPermission)
                        <button class="btn solid-primary btn-sm"
                                x-on:click="showCategory = false; createModal = true; $wire.dispatch('createSubCategory', { group: '{{ $group }}', parentId: category?.id })"
                                x-show="category?.id">
                            <i class="bx bx-plus"></i> Add Sub Category
                        </button>
                    @endcan
                </div>

                @if (isset($category) && !empty($category['childs']) && count($category['childs']) > 0)
                    <div class="space-y-3" wire:sortable="updateOrder"
                         wire:sortable.options="{ group: 'subcategories', animation: 150 }">
                        @foreach ($category['childs'] as $child)
                            <div class="relative w-full" x-data="{
                                showActions: false
                            }"
                                 wire:sortable.item="{{ $child['id'] }}" wire:key="subcat-{{ $child['id'] }}">
                                <div
                                     class="rounded-md border border-gray-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                                    <div class="flex items-center justify-between">
                                        <!-- Left Content -->
                                        <div class="flex items-center gap-4">
                                            <!-- Icon or Image -->
                                            @if (!empty($child['image_path']))
                                                <img class="h-10 w-10 rounded-md object-cover"
                                                     src="{{ $child['image_path'] }}"
                                                     alt="{{ $child['name'] ?? '' }}">
                                            @elseif (!empty($child['icon']))
                                                <i
                                                   class="{{ $child['icon'] }} text-xl text-zinc-600 dark:text-zinc-300"></i>
                                            @endif

                                            <!-- Name + Description -->
                                            <div class="space-y-0.5">
                                                <!-- Badges -->
                                                <div class="mb-2 flex gap-2">
                                                    @if (!empty($child['status_badge']))
                                                        <span>{!! $child['status_badge'] !!}</span>
                                                    @endif
                                                    @if (!empty($child['featured_badge']))
                                                        <span>{!! $child['featured_badge'] !!}</span>
                                                    @endif
                                                </div>

                                                <p class="text-base font-medium text-zinc-800 dark:text-zinc-100">
                                                    {{ $child['name'] ?? ($child['slug'] ?? 'Unnamed') }}
                                                </p>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    {{ $child['description'] ?? ($child['slug'] ? '' : 'No description') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Right Actions -->
                                        <div class="flex items-center gap-2">

                                            <div class="flex gap-2">
                                                <!-- Toggle showActions -->
                                                <button class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                        type="button" x-on:click.stop="showActions = !showActions">
                                                    <i class="bx bx-chevron-up"
                                                       :class="showActions ? 'rotate-180 transition-transform' :
                                                           'transition-transform'"></i>
                                                </button>

                                                @can($updatePermission)
                                                    <!-- Drag Handle -->
                                                    <button class="btn soft-secondary grid size-8 place-items-center p-0 hover:cursor-grab focus:cursor-grabbing dark:text-neutral-400"
                                                            type="button" wire:sortable.handle>
                                                        <i class="bx bx-categories"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-right" x-show="showActions" x-collapse>
                                        @can($updatePermission)
                                            <button class="btn btn-sm soft-primary" type="button" title="Edit"
                                                    x-on:click="editModal = true; $wire.dispatch('findCategory', { id: '{{ $child['id'] }}' }); $wire.dismiss()">
                                                <i class="bx bx-edit mr-1"></i> Edit
                                            </button>
                                        @endcan
                                        @can($deletePermission)
                                            <button class="btn btn-sm soft-danger" type="button" title="Delete"
                                                    x-on:click="removeModal = true; $wire.set('destroyId', '{{ $child['id'] }}'); $wire.dismiss()">
                                                <i class="bx bx-trash mr-1"></i> Delete
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Fallback when no subcategories -->
                <template x-if="!category?.childs || category.childs.length === 0">
                    <div
                         class="rounded-lg border border-dashed border-gray-300 py-6 text-center dark:border-neutral-600">
                        <i class="bx bx-folder-open mb-2 text-3xl text-gray-400 dark:text-neutral-500"></i>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">No sub categories found</p>

                        @can($createPermission)
                            <button class="btn btn-sm mt-2 outline-primary"
                                    x-on:click="showCategory = false; createModal = true; $wire.dispatch('createSubCategory', { group: '{{ $group }}', parentId: category?.id })"
                                    x-show="category?.id">
                                Create First Sub Category
                            </button>
                        @endcan
                    </div>
                </template>
            </div>
        </div>
    </x-panel::ui.dialog>

    <livewire:panel::main.category.create wire:key="category-create" />
    <livewire:panel::main.category.edit wire:key="category-edit" />

    <x-panel::ui.modal.remove />
</div>
