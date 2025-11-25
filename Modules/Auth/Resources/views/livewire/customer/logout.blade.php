<button class="focus:outline-hidden flex w-full items-center gap-2 overflow-hidden rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:focus:bg-zinc-800"
        type="button" wire:click="logout">
    <div class="inline-flex items-center" wire:loading wire:target="logout">
        <span class="btn-spinner" role="status" aria-label="loading"></span>
    </div>

    <span class="whitespace-nowrap">Sign out</span>

    <span class="max-w-3/4 ml-auto overflow-hidden text-ellipsis text-xs text-zinc-500 dark:text-neutral-500">
        {{ $user?->email }}
    </span>
</button>
