<div>
    <div
         class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                Content
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Manage content, edit and more.
            </p>
        </div>
        @can('create-content')
            <a class="btn solid-primary whitespace-nowrap" href="{{ route('panel.web.content.create') }}" wire:navigate>
                <i class="bx bx-plus"></i>
                Add Content
            </a>
        @endcan
    </div>
    <div class="grid grid-cols-1 gap-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <x-panel::ui.treeview :items="$tabs" :levels="['tab', 'section']" :selected="[$tab, $section]" />
            </div>

            <div class="space-y-6 md:col-span-8 xl:col-span-6">
                <div class="card">
                    <div
                         class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 p-4 pb-0 dark:border-neutral-700">
                        <div class="ml-auto inline-flex max-w-lg items-center gap-4 pb-4">
                            <x-panel::ui.forms.search />
                        </div>
                    </div>

                    @if (!$data->isEmpty())
                        <x-panel::ui.table :sort="$sort" :order="$order" :sortable="false">
                            @foreach ($data as $content)
                                <tr wire:key="content-{{ $content['id'] }}">
                                    <td>
                                        <div class="min-w-sm flex items-center gap-3">
                                            <div class="flex-1">
                                                <div class="mt-2" x-data="{ open: false }">
                                                    <button class="text-primary-600 text-xs hover:underline focus:outline-none"
                                                            type="button" x-on:click="open = !open">
                                                        <p class="font-medium text-gray-800 dark:text-neutral-200">
                                                            {{ $content->name }}
                                                        </p>
                                                    </button>
                                                    <div class="mt-2 break-all rounded border border-gray-200 bg-gray-50 p-2 text-xs text-gray-800 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-200"
                                                         x-show="open" x-collapse x-cloak>
                                                        <x-panel::utils.setting-preview :type="$content->input_type"
                                                                                        :value="$content->value" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="whitespace-nowrap">{{ $content->readable_created_at }}</span>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                                         :id="'row-' . $content['id']"
                                                                         icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                                @can('update-content')
                                                    <x-panel::ui.dropdown.item href="{{ route('panel.web.content.edit', $content['id']) }}"
                                                                               wire:navigate>
                                                        <i class='bx bx-edit'></i> Edit
                                                    </x-panel::ui.dropdown.item>
                                                @endcan

                                                <x-panel::ui.dropdown.item href="javascript:void(0)" x-data
                                                                           x-on:click.prevent="toggle($refs.ts);
                                                        window.navigator.clipboard.writeText('{{ $content->display_key }}');
                                                        $dispatch('notify', [{type: 'success', message: 'Display key copied!'}]);
                                                    ">
                                                    <i class='bx bx-copy'></i> Copy Key
                                                </x-panel::ui.dropdown.item>
                                                @can('delete-content')
                                                    <x-panel::ui.dropdown.item href="javascript:void(0)" x-data
                                                                               x-on:click.prevent="$dispatch('confirm-delete', {id: '{{ $content['id'] }}'})">
                                                        <i class='bx bx-trash'></i> Delete
                                                    </x-panel::ui.dropdown.item>
                                                @endcan
                                            </x-panel::ui.dropdown.alpine>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-panel::ui.table>
                    @else
                        <x-panel::ui.table.empty title="There is no data yet."
                                                 @can('create-content')
                                href="{{ route('panel.web.content.create') }}"
                            @endcan
                                                 icon="bx-news" wire:navigate
                                                 description="No content has been created yet. Start by adding new content to engage your audience."
                                                 data="Content" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
