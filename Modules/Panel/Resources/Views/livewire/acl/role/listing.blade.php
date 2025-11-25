<div class="flex flex-col" x-data="{
    tabs: @entangle('tabs'),
    active: @entangle('guard'),
    role: @entangle('role'),
    showRole: false
}">
    <div class="">
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Roles
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage roles, edit and more.
                </p>
            </div>
            @can('create-role')
                <a class="btn solid-primary whitespace-nowrap" href="{{ route('panel.acl.role.create') }}" wire:navigate>
                    <i class="bx bx-plus"></i>
                    Add role
                </a>
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
                                <p>{{ $row->name }}</p>
                            </td>
                            <td>{!! $row->permissionCountBadge() !!}</td>
                            <td>{!! $row->guardBadge() !!}</td>
                            <td>{!! $row->createdAtBadge() !!}</td>
                            <td class="text-left">
                                <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                             :id="$row->id"
                                                             icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                    <!-- Show -->
                                    @can('view-role')
                                        <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                   x-on:click="close(); showRole = true; $wire.showRole('{{ $row->id }}')">
                                            <i class='bx bx-eye'></i> Show
                                        </x-panel::ui.dropdown.item>
                                    @endcan

                                    <!-- Edit -->
                                    @can('update-role')
                                        <x-panel::ui.dropdown.item href="{{ route('panel.acl.role.edit', $row->id) }}"
                                                                   wire:navigate>
                                            <i class='bx bx-edit'></i> Edit
                                        </x-panel::ui.dropdown.item>
                                    @endcan

                                    @can('delete-role')
                                        @if (auth()->user()->can('update-role') || auth()->user()->can('view-role'))
                                            <hr class="mx-2 my-0.5 border-b border-gray-100 dark:border-neutral-700">
                                        @endif
                                    @endcan

                                    <!-- Delete -->
                                    @can('delete-role')
                                        <x-panel::ui.dropdown.item class="text-red-600" href="javascript:void(0)"
                                                                   x-on:click="removeModal = true; $wire.set('destroyId', '{{ $row->id }}')">
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
                <x-panel::ui.table.empty href="{{ route('panel.acl.role.create') }}" title="There is no data yet."
                                         x-on:click="createRole = true" icon="bx-lock" wire:navigate
                                         description="No roles have been created yet. Start by adding a new role to manage access control."
                                         data="Role" />
            @endif
        </div>
    </div>

    <x-panel::ui.dialog title="Role Detail" dialog="showRole" dismiss-action="$wire.dismiss()">
        <div class="skeleton space-y-6" x-bind:class="{ 'skeleton': !role }">
            <!-- Role Header -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100" x-text="role?.name"></h2>
                <div x-html="role?.guard_badge"></div>
            </div>

            <!-- Permissions Section -->
            <div class="space-y-2">
                <h3 class="font-medium text-zinc-700 dark:text-zinc-300">Permissions:</h3>

                <!-- Empty State -->
                <template x-if="!role?.permissions?.length">
                    <p class="text-sm italic text-zinc-500 dark:text-zinc-400">No permissions assigned to this role.
                    </p>
                </template>

                <!-- Permissions List -->
                <ul class="flex flex-wrap gap-2" x-show="role?.permissions?.length">
                    <template x-for="permission in role?.permissions" :key="permission.id">
                        <li x-html="permission.badge"></li>
                    </template>
                </ul>
            </div>
        </div>
    </x-panel::ui.dialog>
</div>
