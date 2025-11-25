<div class="flex flex-col" x-data="{
    tabs: @entangle('tabs'),
    active: @entangle('type'),
    showPost: false,
    removeModal: false
}">
    <div class="">
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Posts
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage posts, edit and more.
                </p>
            </div>
            @can('create-post')
                <a class="btn solid-primary whitespace-nowrap" href="{{ route('panel.web.post.main.create') }}" wire:navigate>
                    <i class="bx bx-plus"></i>
                    Add Post
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
                    <!-- Multilang dropdown removed -->
                </div>
            </div>
            @if (!$data->isEmpty())
                <x-panel::ui.table :sort="$sort" :order="$order" :sortable="false">
                    @foreach ($data as $row)
                        <tr wire:key="post-{{ $row->id }}">
                            <td>
                                <div class="min-w-sm flex items-center gap-3">
                                    <img class="w-36 rounded border border-gray-200 object-cover dark:border-neutral-700"
                                         src="{{ $row->thumbnail_url }}" alt="{{ $row->title ?? 'Post Image' }}"
                                         style="aspect-ratio: {{ $row->aspect_ratio ?? '16/9' }}">
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-600 dark:text-neutral-400">
                                            {{ $row->category_name }}
                                        </p>
                                        <h3 class="text-left text-lg font-medium text-gray-800 dark:text-neutral-200">
                                            {{ $row->title }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-neutral-400">
                                            {{ $row->subject }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $row->author_name }}</span>
                            </td>
                            <td>
                                <span
                                      class="text-sm text-gray-700 dark:text-neutral-300">{{ $row->published_by_name }}</span>
                            </td>
                            <td>
                                {!! $row->status_badge ?? '' !!}
                            </td>
                            <td>{{ $row->readable_created_at }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-panel::ui.dropdown.alpine class="btn soft-secondary grid size-8 place-items-center p-0 dark:text-neutral-400"
                                                                 :id="'row-' . $row->id"
                                                                 icon="bx bx-dots-vertical-rounded hs-dropdown-open:rotate-90">
                                        <!-- Show -->
                                        @can('view-post')
                                            <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                                       x-on:click="close(); showPost = true; $wire.showPost('{{ $row->id }}')">
                                                <i class='bx bx-eye'></i> Show
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                        <!-- Edit -->
                                        @can('update-post')
                                            <x-panel::ui.dropdown.item href="{{ route('panel.web.post.main.edit', $row->id) }}"
                                                                       wire:navigate>
                                                <i class='bx bx-edit'></i> Edit
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                        <hr class="mx-2 my-0.5 border-b border-gray-100 dark:border-neutral-700">
                                        <!-- Delete -->
                                        @can('delete-post')
                                            <x-panel::ui.dropdown.item class="text-red-600" href="javascript:void(0)"
                                                                       x-on:click="removeModal = true; $wire.set('destroyId', '{{ $row->id }}')">
                                                <i class='bx bx-trash'></i> Delete
                                            </x-panel::ui.dropdown.item>
                                        @endcan
                                    </x-panel::ui.dropdown.alpine>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-panel::ui.table>

                <x-panel::ui.table.pagination :data="$data" :per-page="$perPage" />
            @else
                <x-panel::ui.table.empty href="{{ route('panel.web.post.main.create') }}" title="There is no data yet."
                                         icon="bx-news" wire:navigate
                                         description="No posts have been created yet. Start by adding a new post to engage your audience."
                                         data="Post" />
            @endif
        </div>
    </div>
    <!-- Show Post Dialog -->
    <x-panel::ui.dialog title="Post Detail" dialog="showPost" dismiss-action="$wire.dismiss()">
        @if (!$post)
            <div class="skeleton space-y-6">
                <!-- Post Header -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded bg-gray-200 dark:bg-neutral-700"></div>
                        <h2 class="w-full text-xl font-semibold text-zinc-800 dark:text-zinc-100">&nbsp;</h2>
                    </div>
                    <div class="flex gap-2"></div>
                </div>
                <!-- Additional Info (Collapsible) -->
                <div class="mb-2">
                    <div class="mb-2 h-4 w-32 bg-gray-200 dark:bg-neutral-700"></div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        @for ($i = 0; $i < 8; $i++)
                            <div>
                                <div class="mb-1 h-3 w-24 bg-gray-200 dark:bg-neutral-700"></div>
                                <div class="h-3 w-16 bg-gray-100 dark:bg-neutral-800"></div>
                            </div>
                        @endfor
                    </div>
                </div>
                <!-- Content Section -->
                <div class="space-y-2">
                    <div class="mb-1 h-4 w-full bg-gray-200 dark:bg-neutral-700"></div>
                    <div class="h-4 w-3/4 bg-gray-100 dark:bg-neutral-800"></div>
                </div>
            </div>
        @else
            <div class="space-y-6">
                <!-- Post Header -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        @if (!empty($post->thumbnail_url))
                            <img class="h-12 w-12 rounded object-cover" src="{{ $post->thumbnail_url }}"
                                 alt="{{ $post->title }}">
                        @endif
                        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                            {{ $post->title ?? '' }}
                        </h2>
                    </div>
                    <div class="flex gap-2">
                        {!! $post->status_badge ?? '' !!}
                    </div>
                </div>

                <!-- Additional Info (Collapsible) -->
                <div class="mb-2" x-data="{ showInfo: false }">
                    <button class="flex items-center gap-2 text-sm font-medium text-zinc-700 focus:outline-none dark:text-zinc-200"
                            type="button" x-on:click="showInfo = !showInfo">
                        <span class="hover:underline">Additional Info</span>
                        <i class="bx bx-chevron-down" :class="{ 'rotate-180': showInfo }"></i>
                    </button>
                    <div class="mt-3 grid grid-cols-2 gap-4 text-sm" x-show="showInfo" x-collapse>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Category:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->category_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Type:</span>
                            <p class="capitalize text-zinc-600 dark:text-zinc-400">{{ $post->type ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Author:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->author_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Publisher:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->published_by_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Created:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->readable_created_at ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Published:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->readable_published_at ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Tags:</span>
                            <p class="text-zinc-600 dark:text-zinc-400">{{ $post->tags ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="space-y-2">
                    @if (empty($post->content))
                        <p class="text-sm italic text-zinc-500 dark:text-zinc-400">No content available.</p>
                    @else
                        <div class="prose-sm prose-zinc max-w-none dark:prose-invert">
                            {!! $post->content !!}
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </x-panel::ui.dialog>
    <x-panel::ui.modal.remove />
</div>
