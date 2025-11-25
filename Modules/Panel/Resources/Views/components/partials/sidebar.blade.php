@props([
    'currentRoute' => Route::currentRouteName(),
    'sidebarItems' => config('panel.sidebar'),
    'sidebarFooterItems' => config('panel.sidebar'),
    'user' => auth('web')->user(),
])

<div class="sidebar" :class="{ 'open': $store.ui.sidebarOpen }">
    <div class="relative flex h-full max-h-full flex-col">
        <header class="flex items-center justify-between gap-x-2 p-4">
            <div class="flex-none self-center">
                <a class="focus:outline-hidden flex items-center gap-2 focus:opacity-80 dark:text-white"
                   href="{{ route('panel.web.index') }}" aria-label="Brand">
                    <img class="mx-auto h-8 dark:hidden" src="{{ getSetting('logo_gray') }}" alt="Logo">
                    <img class="mx-auto hidden h-8 dark:block" src="{{ getSetting('logo_silver') }}" alt="Logo">

                    <span class="font-semibold text-gray-600 dark:text-gray-300">{{ getSetting('site_name') }}</span>
                </a>
            </div>

            <div class="flex items-center space-x-2">
                <div class="-me-2 lg:hidden">
                    <button class="focus:outline-hidden flex size-6 items-center justify-center gap-x-3 rounded-full border border-gray-200 bg-white text-sm text-gray-600 hover:bg-gray-100 focus:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200 dark:focus:bg-zinc-800 dark:focus:text-zinc-200"
                            type="button" x-on:click="$store.ui.toggleSidebar()">
                        <i class="bx bx-x text-lg"></i>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
            </div>
        </header>

        <nav
             class="h-full overflow-y-auto [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-500 [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-zinc-800 [&::-webkit-scrollbar]:w-2">
            <div class="hs-accordion-group flex w-full flex-col flex-wrap px-2 pb-0">
                <x-panel::ui.list>
                    @foreach (getSidebarItems($currentRoute, $sidebarItems) as $item)
                        @php
                            $permissions = $item['permissions'] ?? [];
                        @endphp

                        @if ($item['type'] === 'divider')
                            @canany($permissions)
                                <x-panel::ui.list.divider :label="$item['label']" />
                            @endcanany
                        @elseif (isset($item['children']))
                            @php
                                // Collect all child permissions for canany
                                $allChildPermissions = [];
                                foreach ($item['children'] as $child) {
                                    if (!empty($child['permissions'])) {
                                        $allChildPermissions = array_merge($allChildPermissions, $child['permissions']);
                                    }
                                }
                            @endphp
                            @canany($allChildPermissions)
                                <x-panel::ui.list.group :label="$item['label']" :icon="$item['icon']" :open="request()->routeIs($item['active'])">
                                    @foreach ($item['children'] as $child)
                                        @php
                                            $childPermissions = $child['permissions'] ?? [];
                                        @endphp
                                        @canany($childPermissions)
                                            @if (isset($child['route']))
                                                <x-panel::ui.list.item href="{{ route($child['route']) }}" wire:navigate
                                                                       :current="request()->routeIs($child['active'])">
                                                    {{ __('panel::sidebar.' . $child['label']) }}
                                                </x-panel::ui.list.item>
                                            @endif
                                        @endcanany
                                    @endforeach
                                </x-panel::ui.list.group>
                            @endcanany
                        @else
                            @if (empty($permissions))
                                <x-panel::ui.list.item href="{{ route($item['route']) }}" wire:navigate
                                                       :current="request()->routeIs($item['active'])" :icon="$item['icon']">
                                    {{ __('panel::sidebar.' . $item['label']) }}
                                </x-panel::ui.list.item>
                            @else
                                @canany($permissions)
                                    <x-panel::ui.list.item href="{{ route($item['route']) }}" wire:navigate
                                                           :current="request()->routeIs($item['active'])" :icon="$item['icon']">
                                        {{ __('panel::sidebar.' . $item['label']) }}
                                    </x-panel::ui.list.item>
                                @endcanany
                            @endif
                        @endif
                    @endforeach
                </x-panel::ui.list>
            </div>
        </nav>

        <footer class="mt-auto border-t border-gray-200 p-2 dark:border-zinc-800">
            <div class="relative inline-flex w-full" x-data="{ open: false }">
                <div class="group block w-full shrink-0 cursor-pointer" x-on:click="open = !open">
                    <div class="flex items-center">
                        <img class="inline-block size-8 shrink-0 rounded-full" id="user-avatar"
                             src="{{ $user?->getAvatar() }}" alt="Avatar">
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $user?->name }}</h3>
                            <p class="text-xs font-medium text-gray-400 dark:text-neutral-500">{{ $user?->email }}</p>
                        </div>

                        <i class="bx bx-chevrons-up-down ml-auto text-lg"></i>
                    </div>
                </div>

                <div class="absolute bottom-full left-0 mb-2 w-60 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-zinc-800 dark:bg-zinc-900"
                     role="menu" aria-orientation="vertical" x-show="open" x-cloak x-on:click.away="open = false"
                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="p-1">
                        @foreach ($sidebarItems['footer'] as $item)
                            <a class="focus:outline-hidden flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:focus:bg-zinc-800"
                               href="{{ route($item['route']) }}" wire:navigate>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                        <livewire:auth::web.logout :user="$user" />
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<div class="fixed inset-0 z-40 bg-black/20 backdrop-blur-[1px] transition-opacity lg:hidden"
     x-show="$store.ui.sidebarOpen" x-transition.opacity x-on:click="$store.ui.sidebarOpen = false">
</div>
