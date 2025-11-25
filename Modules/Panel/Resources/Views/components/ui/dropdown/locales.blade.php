@props([
    'displayLocale' => null,
    'languages' => [],
    'showName' => false, // Option to show name (English) instead of native_name
])

<div class="relative" x-data="{ open: false }">
    <button class="btn soft-secondary inline-flex items-center gap-1 px-1.5 py-2" type="button" x-on:click="open = !open"
            x-on:keydown.escape.window="open = false">
        @php
            $currentLocale = collect($languages)->firstWhere('code', $displayLocale);
        @endphp
        <i class="{{ $currentLocale['flag'] ?? '' }}"></i>
        <small>
            @if ($showName)
                {{ strtoupper($currentLocale['name'] ?? '') }}
            @else
                {{ $currentLocale['uppercase'] ?? '' }}
            @endif
        </small>
    </button>

    <div class="absolute right-0 top-8 z-40 mt-2 w-48 overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800"
         x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1" x-on:click.outside="open = false" x-cloak>
        <div class="py-1">
            @foreach ($languages as $lang)
                <a class="flex items-center gap-x-2 px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-700"
                   href="javascript:void(0)" x-on:click="open = false; {{ $lang['livewire_action'] }}">
                    <span class="{{ $lang['flag'] }}"></span>
                    <span>{{ $lang['native_name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
