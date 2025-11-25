@extends('panel::layouts.master')

@section('title', 'My Account')

@push('style')
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Account']]" />
@endsection

@section('content')
    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 dark:border-neutral-700">
            <nav class="flex gap-1" role="tablist" aria-label="Tabs">
                @foreach ($tabs as $tab)
                    <a class="{{ request()->routeIs($tab['route']) ? 'text-zinc-800 after:bg-zinc-800 dark:text-neutral-200 dark:after:bg-neutral-400' : 'text-zinc-500 hover:text-zinc-800' }} relative mb-2 inline-flex items-center justify-center gap-x-2 rounded-lg px-2 py-1.5 text-sm after:pointer-events-none after:absolute after:inset-x-2 after:-bottom-2 after:z-10 after:h-0.5 hover:bg-zinc-100 focus:bg-zinc-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                       href="{{ route($tab['route']) }}" role="tab" aria-controls="{{ $tab['id'] }}"
                       aria-selected="{{ request()->routeIs($tab['route']) }}" wire:navigate>
                        <i class="{{ $tab['icon'] }}"></i>
                        <span>{{ $tab['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="py-8">
            @if (request()->routeIs('panel.main.account'))
                <livewire:panel::main.profile.account :user="$user" />
            @elseif (request()->routeIs('panel.main.security'))
                <livewire:panel::main.profile.security :user="$user" />
            @elseif (request()->routeIs('panel.main.preference'))
                <livewire:panel::main.profile.preference :user="$user" />
            @endif
        </div>
    </div>
@endsection

@push('script')
    @vite(['Modules/Panel/Resources/assets/js/cropper.js'])
@endpush
