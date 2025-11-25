@props([
    'label' => '',
])

<li class="relative py-2">
    <span class="px-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
        {{ __('panel::sidebar.' . $label) }}
    </span>
</li>
