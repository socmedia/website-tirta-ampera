<div class="focus:outline-hidden relative flex size-8 items-center justify-center rounded-lg border border-zinc-200 text-zinc-800 hover:text-zinc-500 focus:text-zinc-500 disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-zinc-500 dark:focus:text-zinc-500"
     x-data="{ open: false }">
    <!-- Trigger Button -->
    <button class="group relative flex items-center justify-center" type="button" aria-haspopup="true"
            aria-label="Dropdown" x-on:click="open = !open" @keydown.escape.window="open = false" :aria-expanded="open">
        <i class="bx bx-categories text-lg"></i>
    </button>

    <!-- Menu Dot -->
    <span class="absolute -end-0.5 -top-0.5">
        <span class="relative flex">
            <span
                  class="absolute inline-flex size-full animate-ping rounded-full bg-red-400 opacity-75 dark:bg-red-600"></span>
            <span class="relative inline-flex size-2 rounded-full bg-red-500"></span>
            <span class="sr-only">Menu</span>
        </span>
    </span>

    <!-- Dropdown Menu -->
    <div class="md:min-w-lg absolute right-0 top-8 z-30 mt-2 w-full min-w-72 max-w-sm overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-700 dark:bg-zinc-800"
         role="menu" aria-orientation="vertical" x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1" x-on:click.outside="open = false" x-cloak>

        <!-- Your dropdown content goes here -->
        <div class="p-4 text-sm text-zinc-700 dark:text-zinc-200">
            <div class="mb-2 flex items-center justify-end gap-x-1.5">
                <button class="focus:outline-hidden flex shrink-0 items-center justify-center gap-x-1 text-xs text-zinc-500 hover:text-zinc-800 focus:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200 dark:focus:text-zinc-200"
                        type="button" x-on:click="$store.ui.toggleTheme()">
                    <i :class="$store.ui.dark ? 'bx bx-moon' : 'bx bx-sun'"></i>
                    <span x-text="$store.ui.dark ? 'Switch to Light' : 'Switch to Dark'"></span>
                </button>
            </div>

            <div class="my-4 border-t border-gray-100 dark:border-neutral-700"></div>

            <div class="grid sm:grid-cols-2">
                @foreach ($menuItems as $item)
                    @if (isset($item['roles']) && is_array($item['roles']) && count($item['roles']))
                        @hasanyrole(implode('|', $item['roles']))
                            <a class="flex gap-x-4 rounded-lg p-3 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                               href="{{ $item['route'] ? route($item['route']) : 'javascript:void(0)' }}">
                                <i class="{{ $item['icon'] }} mt-1 text-lg text-gray-800 dark:text-neutral-200"></i>
                                <div class="grow">
                                    <span
                                          class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $item['label'] }}</span>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">{{ $item['description'] }}</p>
                                </div>
                            </a>
                        @endhasanyrole
                    @else
                        <a class="flex gap-x-4 rounded-lg p-3 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                           href="{{ $item['route'] ? route($item['route']) : 'javascript:void(0)' }}">
                            <i class="{{ $item['icon'] }} mt-1 text-lg text-gray-800 dark:text-neutral-200"></i>
                            <div class="grow">
                                <span
                                      class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $item['label'] }}</span>
                                <p class="text-sm text-gray-500 dark:text-neutral-500">{{ $item['description'] }}</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
</div>
