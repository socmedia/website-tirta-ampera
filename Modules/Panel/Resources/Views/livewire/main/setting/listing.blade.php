<div class="flex flex-col" x-data="{
    tabs: @entangle('tabs'),
    active: @entangle('tab'),
    settings: @entangle('settings')
}">
    <div>
        <!-- Tabs Navigation -->
        <div
             class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 pb-3 dark:border-neutral-700">
            <nav class="flex gap-1 overflow-auto" role="tablist" aria-label="Tabs">
                <template x-for="(tab, index) in tabs" :key="index">
                    <button class="tab-button" type="button" role="tab" :aria-controls="tab.group"
                            x-on:click="active = tab.group; $wire.set('tab', tab.group)"
                            :class="active === tab.group ? 'tab-active' : 'tab-inactive'"
                            :aria-selected="active === tab.group">
                        <span x-text="tab.label"></span>
                        <span class="tab-count" x-show="tab.count !== undefined" x-text="`(${tab.count})`"></span>
                    </button>
                </template>
            </nav>

            @role('Developer')
                <a class="btn solid-primary" href="{{ route('panel.main.setting.create') }}" wire:navigate>
                    <i class="bx bx-plus"></i> Add setting
                </a>
            @endrole
        </div>

        <!-- Settings List -->
        <div class="max-w-screen-md py-10">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
                @forelse($settings as $index => $setting)
                    <div class="contents" x-data="{
                        editing: false,
                        startEdit() { this.editing = true; },
                        dismiss() { this.editing = false; }
                    }">
                        <!-- Setting Info -->
                        <div class="{{ user()->hasRole('Developer') ? '' : 'pt-3' }} lg:col-span-5">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $setting['name'] }}</p>
                            @role('Developer')
                                <span class="badge soft-dark">{{ $setting['display_key'] ?? $setting['key'] }}</span>
                            @endrole
                        </div>

                        <!-- Setting Value -->
                        <div class="space-y-4 lg:col-span-7">
                            <!-- View Mode -->
                            <div class="input-group" x-show="!editing">
                                <div class="input-field disabled {{ user()->hasRole('Developer') ? 'has-icon-right' : '' }} cursor-pointer"
                                     x-on:click="startEdit()">
                                    @if ($setting['type'] === 'input:checkbox')
                                        <span
                                              class="{{ $setting['value'] ? 'badge soft-primary' : 'badge soft-danger' }}">
                                            <span>{{ $setting['value'] ? 'Yes' : 'No' }}</span>
                                        </span>
                                    @elseif($setting['type'] === 'input:image')
                                        <img class="h-8 rounded" src="{{ $setting['value'] }}">
                                    @elseif($setting['type'] === 'input:number')
                                        <span>{{ number($setting['value'], 0) ?? '—' }}</span>
                                    @elseif($setting['type'] === 'input:text' || $setting['type'] === 'textarea')
                                        <span class="line-clamp-2 break-all">{{ $setting['value'] ?? '—' }}</span>
                                    @elseif($setting['type'] === 'input:url')
                                        <span class="line-clamp-1 break-all">{{ $setting['value'] ?? '—' }}</span>
                                    @elseif($setting['type'] === 'json')
                                        <code
                                              class="line-clamp-3 block whitespace-pre-wrap break-all text-xs text-gray-700 dark:text-neutral-300">{{ $setting['value'] }}</code>
                                    @else
                                        <span class="line-clamp-2 break-all">{{ $setting['value'] ?? '—' }}</span>
                                    @endif
                                </div>
                                @role('Developer')
                                    <a class="input-icon-right btn btn-sm soft-primary rounded-l-none border border-y border-l-0"
                                       href="{{ route('panel.main.setting.edit', $setting['id']) }}" wire:navigate>
                                        <i class="bx bx-edit"></i>
                                    </a>
                                @endrole
                            </div>

                            <!-- Edit Mode -->
                            <div x-show="editing" x-cloak>
                                <form
                                      wire:submit.prevent="saveSetting('{{ $setting['id'] }}', '{{ $index }}')">
                                    @php
                                        $value = $setting['value'];
                                    @endphp

                                    @if ($setting['type'] === 'input:number')
                                        <input class="form-input text-right" value="{{ $value }}"
                                               x-mask:dynamic="$money($input)"
                                               x-on:change="$wire.set('settings.{{ $index }}.value', `${$el.value.replace(/[A-Za-z% ,.]/g, '')}`)" />
                                    @elseif($setting['type'] === 'textarea')
                                        <textarea class="form-textarea w-full" rows="4" wire:model="settings.{{ $index }}.value"></textarea>
                                    @elseif($setting['type'] === 'input:image')
                                        <input class="form-file w-full" type="file" placeholder="Image URL"
                                               wire:model.lazy="settings.{{ $index }}.uploaded_file">
                                    @elseif($setting['type'] === 'input:url')
                                        <input class="form-input w-full" type="url"
                                               wire:model="settings.{{ $index }}.value">
                                    @elseif($setting['type'] === 'input:email')
                                        <input class="form-input w-full" type="email"
                                               wire:model="settings.{{ $index }}.value">
                                    @elseif($setting['type'] === 'json')
                                        <textarea class="font-mono form-textarea w-full text-xs" rows="6"
                                                  wire:model="settings.{{ $index }}.value"></textarea>
                                    @elseif ($setting['type'] === 'input:checkbox')
                                        <div class="flex items-center">
                                            <input class="form-checkbox" id="{{ $setting['key'] }}" type="checkbox"
                                                   checked="{{ $value ? 'true' : 'false' }}"
                                                   x-on:change="$wire.set('settings.{{ $index }}.value', $el.checked)">
                                            <label class="ml-2 text-sm"
                                                   for="{{ $setting['key'] }}">{{ $setting['name'] }}</label>
                                        </div>
                                    @else
                                        <input class="form-input w-full" type="text"
                                               wire:model="settings.{{ $index }}.value">
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="mt-4 flex gap-2">
                                        <button class="btn btn-sm soft-primary" type="submit"
                                                x-on:click="dismiss()">Save</button>
                                        <button class="btn btn-sm solid-white" type="button"
                                                x-on:click="dismiss()">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full flex flex-col items-center justify-center py-12">
                        <div class="mb-2 text-4xl text-gray-400"><i class="bx bx-cog"></i></div>
                        <div class="mb-1 text-lg font-semibold">No settings found</div>
                        <div class="mb-4 text-gray-500">Add settings to manage configuration for your app.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- No need for @push('script') Alpine component, as editing is now handled inline above --}}
