<div class="flex flex-col" x-data="{
    createPermission: false,
    updatePermission: false,
    tabs: @entangle('tabs'),
    active: @entangle('guard')
}">
    <div class="">
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Permissions
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage permissions, edit and more.
                </p>
            </div>
            @can('create-permission')
                <button class="btn solid-primary whitespace-nowrap" type="button" x-on:click="createPermission = true">
                    <i class="bx bx-plus"></i>
                    Add permission
                </button>
            @endcan
        </div>

        <div class="card">
            <div
                 class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 p-4 pb-0 dark:border-neutral-700">
                <nav class="flex gap-1 overflow-auto" role="tablist" aria-label="Tabs">
                    <template x-for="(tab, index) in tabs" :key="index">
                        <button class="tab-button" type="button" role="tab" :aria-controls="tab.id"
                                x-on:click="active = tab.id; $wire.set('guard', tab.id)"
                                :class="active === tab.id ? 'tab-active' : 'tab-inactive'"
                                :aria-selected="active === tab.id">
                            <span x-text="tab.label"></span>
                            <span class="tab-count" x-show="tab.count !== undefined" x-text="`(${tab.count})`"></span>
                        </button>
                    </template>
                </nav>
                <div class="ml-auto max-w-lg pb-4">
                    <x-panel::ui.forms.search />
                </div>
            </div>

            @if ($data->isNotEmpty())
                <x-panel::ui.table sort="name" order="asc">
                    @foreach ($data as $row)
                        <tr>
                            <td>
                                <p>{{ $row['name'] }}</p>
                            </td>
                            <td>{!! $row->guardBadge() !!}</td>
                            <td>{!! $row->createdAtBadge() !!}</td>
                            <td>
                                <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                             :id="$row->id"
                                                             icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                    <!-- Edit -->
                                    @can('update-permission')
                                        <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                   x-on:click="close(); updatePermission = true; $wire.editPermission('{{ $row->id }}')">
                                            <i class='bx bx-edit'></i> Edit
                                        </x-panel::ui.dropdown.item>
                                    @endcan

                                    <hr class="mx-2 my-0.5 border-b border-gray-100 dark:border-neutral-700">

                                    <!-- Delete -->
                                    @can('delete-permission')
                                        <x-panel::ui.dropdown.item class="text-red-600" href="javascript:void(0)"
                                                                   x-on:click="close(); $wire.set('destroyId', '{{ $row->id }}')">
                                            <i class='bx bx-trash'></i> Delete
                                        </x-panel::ui.dropdown.item>
                                    @endcan
                                </x-panel::ui.dropdown.alpine>
                            </td>
                        </tr>
                    @endforeach
                </x-panel::ui.table>

                <x-panel::ui.table.pagination :data="$data" :per-page="$perPage" />
            @else
                <x-panel::ui.table.empty href="javascript:void(0)" title="There is no data yet."
                                         x-on:click="createPermission = true" icon="bx-lock"
                                         description="No permissions have been created yet. Start by adding a new permission to manage access control."
                                         data="Permission" />
            @endif
        </div>
    </div>

    <livewire:panel::acl.permission.create />
    <livewire:panel::acl.permission.edit />
</div>
