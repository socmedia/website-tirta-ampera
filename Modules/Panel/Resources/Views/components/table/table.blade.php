<div class="{{ isset($withoutCard) ? '' : 'card' }}" x-data="{
    deleteConfirm: false,
}">
    @isset($searchable)
        @if ($searchable)
            <div class="p-4">
                <div class="flex flex-wrap justify-end gap-2 md:gap-4">
                    <div class="relative w-8/12 md:w-4/12 lg:w-3/12">
                        <label class="sr-only" for="search">Search</label>
                        <input class="form-input pl-11" name="search" type="text" wire:model.lazy="search"
                               placeholder="Pencarian...">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center pl-4">
                            <i class="bx bx-search"></i>
                        </div>
                    </div>

                    @isset($searchAction)
                        <div class="relative">
                            {{ $searchAction }}
                        </div>
                    @endisset
                </div>
            </div>
        @endif
    @endisset

    @isset($filter)
        {{ $filter }}
    @endisset

    <div class="overflow-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="border dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    {{-- Table Header --}}
                    <x-panel::table.thead :columns="$customTable->columns" :sort="$sort" :order="$order" />

                    @isset($sortable)
                        {{-- Table Body --}}
                        <x-panel::table.tbody wire:sortable="updateOrder" wire:sortable.options="{ animation: 100 }">
                            {{ $slot }}
                        </x-panel::table.tbody>
                    @else
                        {{-- Table Body --}}
                        <x-panel::table.tbody>
                            {{ $slot }}
                        </x-panel::table.tbody>
                    @endisset
                </table>
            </div>
        </div>
    </div>

    <div class="p-4 pb-2">
        <x-panel::utils.pagination :custom-table="$customTable" :paginator="$listing" />
    </div>

    <x-panel::utils.remove-modal />
</div>
