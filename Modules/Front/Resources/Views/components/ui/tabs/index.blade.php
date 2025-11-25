<div x-data="{
    tabs: {{ json_encode($tabs) }},
    active: null,
}">
    <div
         class="flex flex-wrap items-center justify-between gap-3 overflow-auto border-b border-zinc-200 p-3 pb-0 dark:border-neutral-700">
        <nav class="flex gap-1" role="tablist" aria-label="Tabs">
            <template x-for="(tab, index) in tabs" :key="index">
                <button class="tab-button" type="button" role="tab" :aria-controls="tab.id"
                        x-on:click="active = tab.id" :class="active === tab.id ? 'tab-active' : 'tab-inactive'"
                        :aria-selected="active === tab.id">
                    <i :class="tab.icon" x-show="tab.icon"></i>
                    <span x-text="tab.label"></span>
                    <span class="tab-count" x-show="tab.count !== undefined" x-text="`(${tab.count})`"></span>
                </button>
            </template>
        </nav>
    </div>

    <div>
        {{ $slot }}
    </div>
</div>
