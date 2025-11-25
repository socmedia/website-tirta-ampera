<div id="navbar"
     @if ($alwaysFixed) class="navbar always-fixed"
    @else
        class="navbar"
        x-init="$store.ui.setupScrollThreshold($el, 'navbar')"
        :class="$store.ui.navbarScrolled ? 'scrolled' : ''" @endif>
    <nav class="container" x-data="{ open: false, submenu: null }">

        <div class="navbar-flex">
            {{-- Logo --}}
            <a class="navbar-logo" href="{{ url('/') }}" wire:navigate>
                @if ($alwaysFixed)
                    <img class="h-14" src="{{ getSetting('logo') }}" alt="Logo" />
                @else
                    <img class="h-14" src="{{ getSetting('logo') }}" alt="Logo"
                         :class="($store.ui.navbarScrolled) ? 'hidden' : 'block'" />
                    <img class="h-14" src="{{ getSetting('logo_square') }}" alt="Logo Square"
                         :class="($store.ui.navbarScrolled) ? 'block' : 'hidden'" x-cloak />
                @endif
            </a>

            <div class="navbar-right">
                {{-- Desktop Nav --}}
                <div class="navbar-links">
                    @foreach ($menuItems as $menu)
                        @if (isset($menu['submenu']))
                            <div class="navbar-dropdown" x-data="{ open: false, leaveTimeout: null }"
                                 x-on:mouseenter="clearTimeout(leaveTimeout); open = true"
                                 x-on:mouseleave="
                                    leaveTimeout = setTimeout(() => { open = false }, 250);
                                ">
                                <a class="navbar-link navbar-dropdown-button" href="{{ route($menu['route']) }}"
                                   tabindex="0"
                                   @if (isset($menu['route'])) aria-current="{{ request()->routeIs($menu['active']) ? 'page' : '' }}" @endif
                                   :class="[
                                       'navbar-link',
                                       {{ json_encode(request()->routeIs($menu['active'])) }} ? 'active' : '',
                                       $store.ui.navbarScrolled && !(
                                           {{ json_encode(request()->routeIs($menu['active'])) }}) ? 'scrolled' : '',
                                   ]">
                                    {{ __($menu['label']) }}
                                    <i class="bx bx-chevron-down text-sm"></i>
                                </a>
                                <div class="dropdown-menu" x-show="open" x-cloak
                                     x-on:mouseenter="clearTimeout(leaveTimeout); open = true"
                                     x-on:mouseleave="
                                        leaveTimeout = setTimeout(() => { open = false }, 100);
                                    "
                                     x-on:keydown.escape.window="open = false">
                                    @foreach ($menu['submenu'] as $submenu)
                                        <a class="dropdown-item"
                                           @if (isset($submenu['route']) && $submenu['route']) href="{{ route($submenu['route']) }}"
                                                wire:navigate
                                            @else
                                                href="#" @endif>
                                            {{ __($submenu['label']) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ route($menu['route']) }}" wire:navigate
                               :class="[
                                   'navbar-link',
                                   {{ json_encode(request()->routeIs($menu['active'])) }} ? 'active' : '',
                                   $store.ui.navbarScrolled && !(
                                       {{ json_encode(request()->routeIs($menu['active'])) }}) ? 'scrolled' : '',
                               ]">
                                {{ __($menu['label']) }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Right: Search --}}
                <div class="ml-4 flex items-center gap-2">
                    <livewire:front::ui.partials.search />

                    {{-- Hamburger --}}
                    <button class="grid place-items-center hover:text-sky-600 lg:hidden" x-on:click="open = !open">
                        <i :class="open ? 'bx bx-x' : 'bx bx-menu'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="mobile-nav w-9/10 absolute left-1/2 z-50 mt-2 -translate-x-1/2 space-y-2 rounded-md px-2 py-4 shadow-md"
             x-show="open" x-cloak x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
             x-transition>
            @foreach ($menuItems as $index => $menu)
                @if (isset($menu['submenu']))
                    <div class="mobile-submenu-block" x-data="{ smOpen: false }">
                        <button class="mobile-nav-link flex w-full items-center justify-between" type="button"
                                x-on:click="smOpen = !smOpen">
                            <span>{{ __($menu['label']) }}</span>
                            <i :class="smOpen ? 'bx bx-chevron-up' : 'bx bx-chevron-down'"></i>
                        </button>
                        <div class="mobile-submenu space-y-1 pl-4" x-show="smOpen" x-cloak>
                            @foreach ($menu['submenu'] as $submenu)
                                <a class="mobile-nav-link"
                                   @if (isset($submenu['route']) && $submenu['route']) href="{{ route($submenu['route']) }}"
                                        wire:navigate
                                    @else
                                        href="#" @endif>
                                    {{ __($submenu['label']) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a class="{{ request()->routeIs($menu['active']) ? 'mobile-nav-link mobile-nav-link-active' : 'mobile-nav-link' }}"
                       href="{{ route($menu['route']) }}" wire:navigate>
                        {{ __($menu['label']) }}
                    </a>
                @endif
            @endforeach

            {{-- WhatsApp Quick Access Mobile --}}
            @if (!empty($waLink) && !empty($waText))
                <div class="mt-2">
                    <a class="flex items-center justify-center gap-2 rounded-md border border-green-100 bg-green-50 px-3 py-2 text-base font-bold text-green-600 hover:text-green-700"
                       href="{{ $waLink }}" aria-label="Chat WhatsApp" target="_blank" rel="noopener">
                        <i class="bxl bx-whatsapp text-2xl"></i>
                        <span>{{ $waText }}</span>
                    </a>
                </div>
            @endif
        </div>
    </nav>
</div>
