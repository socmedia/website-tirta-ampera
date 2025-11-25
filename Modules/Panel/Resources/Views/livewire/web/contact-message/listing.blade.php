<div x-data="{

    hasMoreItems: @entangle('hasMoreItems'),
    removeModal: false,
    sidebarOpen: true,
    toggle() {
        this.sidebarOpen = !this.sidebarOpen
    },
    sidebarListEl: null,
    loadingMore: false,
    init() {
        this.sidebarListEl = this.$refs.sidebarList;
        if (this.sidebarListEl) {
            this.sidebarListEl.addEventListener('scroll', () => {
                if (
                    !this.loadingMore &&
                    this.sidebarListEl.scrollTop + this.sidebarListEl.clientHeight >= this.sidebarListEl.scrollHeight - 40
                ) {
                    // Only load more if there are more messages to load
                    if (this.hasMoreItems) {
                        this.loadingMore = true;
                        $wire.loadMore().then(() => {
                            this.loadingMore = false;
                        });
                    } else {
                        this.loadingMore = false;
                    }
                }
            });
        }
    }
}">
    <div class="font-sans grid h-[72vh] overflow-hidden rounded-lg bg-gray-100 text-sm shadow-sm transition-all duration-200 dark:bg-neutral-900"
         :class="sidebarOpen ? 'grid-cols-[275px_1fr] sm:grid-cols-[325px_1fr]' : 'grid-cols-1'">

        <!-- Sidebar -->
        <div class="flex h-[inherit] w-[275px] min-w-0 flex-col border-r border-gray-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 sm:w-[325px]"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-10"
             x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-10" x-show="sidebarOpen">
            <!-- Search -->
            <div class="flex h-16 items-center justify-between border-b border-gray-200 p-3 dark:border-neutral-700">
                <x-panel::ui.forms.search wire:model.lazy="keyword" />
                @can('view-contact-message')
                    <x-panel::ui.dropdown.alpine class="btn soft-secondary ml-2 px-1.5 py-1.5"
                                                 icon="bx bx-dots-vertical-rounded" width="w-36">
                        <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                   x-on:click="toggle($refs.ts); $dispatch('notify', [{type: 'default', message: 'Your download is being processed. Please wait...' }])"
                                                   wire:click="export('xlsx')">
                            Export .xlsx
                        </x-panel::ui.dropdown.item>
                        <x-panel::ui.dropdown.item href="javascript:void(0)"
                                                   x-on:click="toggle($refs.ts); $dispatch('notify', [{type: 'default', message: 'Your download is being processed. Please wait...' }])"
                                                   wire:click="export('csv')">
                            Export .csv
                        </x-panel::ui.dropdown.item>
                    </x-panel::ui.dropdown.alpine>
                @endcan
            </div>
            <!-- Tabs -->
            <div class="flex border-b border-gray-200 px-4 py-3 dark:border-neutral-700">
                @foreach (['all' => 'All', 'seen' => 'Seen', 'unseen' => 'Unseen'] as $key => $label)
                    <button class="btn btn-sm {{ $tab === $key ? 'soft-primary' : 'link-secondary' }}"
                            wire:click="$set('tab', '{{ $key }}')">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Mail List -->
            <div class="h-full flex-1 overflow-y-auto" x-ref="sidebarList">
                <div class="">
                    @forelse($messages as $message)
                        <div class="{{ $message->row_bg }} cursor-pointer border-b border-gray-200 px-4 py-3 hover:bg-gray-50 dark:border-neutral-700 dark:hover:bg-gray-700"
                             wire:click="$set('selectedMessageId', {{ $message->id }})"
                             x-on:click="if (window.innerWidth < 768) sidebarOpen = false">
                            <div class="flex justify-between">
                                <h4 class="truncate font-medium text-gray-800 dark:text-gray-100">
                                    {{ $message->name ?? $message->email }}</h4>
                                <span
                                      class="text-xs text-gray-400 dark:text-gray-500">{{ $message->formatted_created_at }}</span>
                            </div>
                            <div class="truncate font-semibold text-gray-700 dark:text-gray-200">
                                {{ $message->subject ?? 'No Subject' }}</div>
                            <div class="truncate text-xs text-gray-500 dark:text-gray-400">
                                {{ Str::limit($message->message, 60) }}</div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-400 dark:text-gray-500">No messages found.</div>
                    @endforelse
                    <template x-if="hasMoreItems">
                        <div class="p-4 text-center text-gray-400 dark:text-gray-500">
                            <span class="mr-2 animate-spin"><i class="bx bx-loader"></i></span> Loading more...
                        </div>
                    </template>
                </div>
            </div>

            <!-- Pagination -->
            <div
                 class="sticky bottom-0 border-t border-gray-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }}
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex h-full flex-col overflow-auto bg-gray-50 dark:bg-neutral-900">

            <div class="min-w-xs w-full">
                <!-- Action Bar -->
                @if ($selectedMessage)
                    <div
                         class="sticky top-0 flex h-16 items-center justify-between border-b border-gray-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                            <button class="btn soft-secondary px-1.5 py-1.5" x-on:click="toggle()">
                                <i class="bx bx-menu text-base"></i>
                            </button>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                            <button class="btn soft-secondary px-1.5 py-1.5" wire:click="dismiss">
                                <i class="bx bx-x text-base"></i>
                            </button>
                            @can('update-contact-message')
                                @if (!$selectedMessage->seen_at)
                                    <button class="btn btn-sm soft-primary py-1.5"
                                            wire:click="markAsSeen({{ $selectedMessage->id }})">
                                        <i class="bx bx-envelope-open"></i> Mark as seen
                                    </button>
                                @else
                                    <button class="btn btn-sm soft-secondary py-1.5"
                                            wire:click="markAsUnseen({{ $selectedMessage->id }})">
                                        <i class="bx bx-envelope"></i> Mark as unseen
                                    </button>
                                @endif
                            @endcan
                            @can('delete-contact-message')
                                <button class="btn btn-sm soft-danger py-1.5"
                                        x-on:click="removeModal = true; $wire.set('destroyId', '{{ $selectedMessage->id }}')">
                                    <i class="bx bx-trash"></i> Remove
                                </button>
                            @endcan
                        </div>
                    </div>
                @else
                    <div
                         class="sticky top-0 flex h-16 items-center border-b border-gray-200 bg-white p-3 dark:border-neutral-700 dark:bg-neutral-900">
                        <button class="btn soft-secondary px-1.5 py-1.5" x-on:click="toggle()" x-transition>
                            <i class="bx bx-menu text-base"></i>
                        </button>
                    </div>
                @endif

                <!-- Email Header -->
                <div class="border-b border-gray-200 px-6 py-4 dark:border-neutral-700">
                    @if ($selectedMessage)
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $selectedMessage->subject ?? 'No Subject' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    <span>From: {{ $selectedMessage->name ?? $selectedMessage->email }}</span>
                                    @if ($selectedMessage->email)
                                        <span>({{ $selectedMessage->email }})</span>
                                    @endif
                                    <span>•</span>
                                    <span>{{ $selectedMessage->formatted_created_at }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if ($selectedMessage->email)
                                    <a class="btn btn-sm soft-primary" href="mailto:{{ $selectedMessage->email }}"
                                       title="Send Email">
                                        <i class="bx bx-envelope"></i>
                                        <span>Email</span>
                                    </a>
                                @endif
                                @if ($selectedMessage->whatsapp_number)
                                    <a class="btn btn-sm soft-primary"
                                       href="https://wa.me/{{ $selectedMessage->whatsapp_formatted }}?text={{ urlencode('Hi ' . ($selectedMessage->name ?? '') . ',') }}"
                                       title="Send WhatsApp" target="_blank">
                                        <i class="bxl bx-whatsapp"></i>
                                        <span>WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex min-h-56 flex-col items-center justify-center sm:h-[62vh]">
                            <!-- Large Icon -->
                            <div class="mb-4 text-[64px] text-gray-400 dark:text-gray-600">
                                <i class="bx bxs-envelope-open"></i>
                            </div>
                            <!-- Main message -->
                            <div class="mb-2 text-center text-lg font-medium text-gray-500 dark:text-gray-400">
                                Please select a message from the list to view its details.
                            </div>
                            <!-- Subtext actions -->
                            <div class="space-y-1 text-center text-sm text-gray-400 dark:text-gray-500">
                                <div class="flex items-center justify-center space-x-1">
                                    <span>Click on a message to read, or manage it.</span>
                                </div>
                                <div class="flex items-center justify-center space-x-1">
                                    <span>Use the <span class="font-semibold">Delete</span> button to remove
                                        messages.</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Message Thread (single message) -->
                @if ($selectedMessage)
                    <div class="h-full space-y-4 overflow-y-auto p-6">
                        <div class="rounded bg-white p-4 text-sm shadow dark:bg-neutral-900">
                            <div class="mb-2 flex items-center justify-between">
                                <div class="font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $selectedMessage->name ?? $selectedMessage->email }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $selectedMessage->formatted_created_at }}
                                </div>
                            </div>
                            <div class="whitespace-pre-line text-gray-700 dark:text-gray-200">
                                {{ $selectedMessage->message }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Reply (optional, if you want to allow admin to reply) -->
                {{--
                @if (isset($message) && $message)
                <div class="sticky bottom-0 p-4 bg-white border-t border-gray-200 dark:border-neutral-700 dark:bg-neutral-900">
                    <form wire:submit.prevent="reply({{ $message->id }})" class="flex items-center space-x-3">
                        <input class="text-gray-900 bg-gray-50 border-gray-200 form-input dark:border-neutral-700 dark:bg-neutral-900 dark:text-gray-100"
                               type="text" wire:model.defer="replyMessage" placeholder="Add a comment...">
                        <button class="w-10 h-10 btn soft-primary" type="submit"><i class="bx bxs-send"></i></button>
                    </form>
                </div>
                @endif
                --}}
            </div>
        </div>
    </div>

    <x-panel::ui.modal.remove />
</div>
