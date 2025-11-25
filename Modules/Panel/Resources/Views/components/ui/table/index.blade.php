@props([
    'footer' => null,
    'sortable' => false,
    'freezeAction' => true,
])
<div x-data="{
    columns: $wire.columns,
    sort: $wire.sort,
    order: $wire.order,
    removeModal: false,
    handleSort(column) {
        if (this.sort === column) {
            this.order = this.order === 'asc' ? 'desc' : 'asc';
        } else {
            this.sort = column;
            this.order = 'asc';
        }
        $wire.sortOrder(column);
    },
}">
    <div class="table-responsive" data-scroll-container>
        <table class="{{ $freezeAction ? 'freeze-right' : '' }} table" wire:loading.class="skeleton"
               wire:target="checks,checkAll,search,perPage,page">
            <thead>
                <tr>
                    <template x-for="(column, index) in columns" :key="index + '-' + column.name">
                        <th scope="col">
                            <template x-if="column.name === 'select'">
                                <x-panel::ui.forms.checkbox wire:model.lazy="checkAll" />
                            </template>

                            <template x-if="column.sortable">
                                <button class="flex w-full items-center justify-between whitespace-nowrap uppercase"
                                        type="button" :class="{ 'text-primary': sort === column.name }"
                                        x-on:click="handleSort(column.name)">
                                    <span x-text="column.label"></span>
                                    <div class="ml-1 flex items-center">
                                        <template x-if="sort === column.name">
                                            <i class="bx"
                                               :class="order === 'asc' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </template>
                                        <template x-if="sort !== column.name">
                                            <i class="bx bx-chevrons-up-down"></i>
                                        </template>
                                    </div>
                                </button>
                            </template>

                            <template x-if="!column.sortable && column.name !== 'select'">
                                <span x-text="column.label"></span>
                            </template>
                        </th>
                    </template>
                </tr>
            </thead>

            @if ($sortable)
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700" wire:sortable="updateOrder"
                       wire:sortable.options="{ animation: 100 }">
                    {{ $slot }}
                </tbody>
            @else
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    {{ $slot }}
                </tbody>
            @endif

            @if ($footer)
                <tfoot class="divide-y divide-gray-200 dark:divide-neutral-700">
                    {{ $footer }}
                </tfoot>
            @endif
        </table>
    </div>

    <x-panel::ui.modal.remove />
</div>
