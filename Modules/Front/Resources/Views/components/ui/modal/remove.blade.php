<div class="fixed inset-0 z-50 bg-black/20 backdrop-blur-[1px] transition-opacity" x-cloak x-show="removeModal">
</div>

<div class="modal modal-md" role="dialog" tabindex="-1" x-show="removeModal"
     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-trap="removeModal"
     x-cloak>
    <div class="modal-wrapper">
        <!-- Close Button -->
        <div class="modal-close">
            <button type="button" aria-label="Close" x-on:click="removeModal = false; $wire.set('destroyId', null)">
                <i class="bx bx-x"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="modal-body">
            <div class="flex gap-x-4 md:gap-x-7">
                <span
                      class="modal-icon border-red-50 bg-red-100 text-red-500 dark:border-red-600 dark:bg-red-700 dark:text-red-100">
                    <i class="bx bx-info-shield text-2xl"></i>
                </span>

                <div class="text-left">
                    <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        Delete Data
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                        Are you sure you want to delete this data? This action cannot be undone and all
                        associated information will be permanently removed.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button class="btn ghost-white btn-sm" type="button"
                    x-on:click="removeModal = false; $wire.set('destroyId', null)">
                Cancel
            </button>
            <x-panel::ui.buttons.spinner class="solid-danger btn-sm"
                                         x-on:click="removeModal = false; $wire.handleDestroy()"
                                         wire:target="handleDestroy">
                Delete data
            </x-panel::ui.buttons.spinner>
        </div>
    </div>
</div>
