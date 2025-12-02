<div class="input-group space-y-2">
    <div class="relative">
        <input id="search" type="text"
               {{ $attributes->merge(['class' => 'input-field has-icon-right peer rounded-full']) }}
               wire:model.lazy="search" {{ $attributes }} />

        <span class="input-icon-right text-gray-400 hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white">
            <i class="bx bx-search"></i>
        </span>
    </div>
</div>
