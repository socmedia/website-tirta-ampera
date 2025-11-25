<div x-data="{
    showSearch: false
}">
    <button class="grid place-items-center hover:text-blue-600" aria-label="{{ __('front::global.search') }}"
            x-on:click="showSearch = true">
        <i class="bx bx-search" aria-hidden="true"></i>
    </button>
    <x-front::ui.modal.index :title="__('front::global.search')" modal="showSearch" variant="modal-md" dismissAction="$wire.dismiss()">
        <div class="p-3 sm:p-6">
            <!-- Tabs -->
            <nav class="mb-4 flex border-b border-neutral-200" role="tablist"
                 aria-label="{{ __('front::global.search_tabs') }}">
                @foreach ($tabs as $key => $label)
                    <button class="{{ $tab === $key ? 'border-blue-200 text-blue-600' : 'border-transparent text-neutral-500 hover:text-blue-600' }} -mb-px border-b-2 px-4 py-2 text-sm font-medium transition-all focus:outline-none"
                            id="search-tab-{{ $key }}" role="tab"
                            aria-selected="{{ $tab === $key ? 'true' : 'false' }}"
                            aria-controls="search-tabpanel-{{ $key }}"
                            tabindex="{{ $tab === $key ? '0' : '-1' }}" wire:click="setTab('{{ $key }}')">
                        {{ __($label) }}
                    </button>
                @endforeach
            </nav>

            <!-- Search Form -->
            <form class="input-group mb-6 space-y-2" role="search" aria-label="{{ __('front::global.search') }}"
                  autocomplete="off" @submit.prevent>
                <div class="relative">
                    <input class="input-field has-icon-right peer" id="search" name="search" type="text"
                           aria-label="{{ __('front::global.search_placeholder') }}" wire:model.lazy="keyword"
                           placeholder="{{ __('front::global.search_placeholder') }}" autocomplete="off" />

                    <span class="input-icon-right text-gray-400 hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                          aria-hidden="true">
                        <i class="bx bx-search"></i>
                    </span>
                </div>
            </form>

            <!-- Results Listing -->
            <div x-data x-init="$store.infiniteScroll({
                hasMoreItems: @entangle('hasMorePages'),
                resultsListEl: $refs.resultsList,
                __wire: $wire
            }).init()">
                <ul class="max-h-72 overflow-auto" role="list" aria-live="polite"
                    aria-label="{{ __('front::global.search_results') }}" x-ref="resultsList">
                    @if (!$results->isEmpty())
                        <li class="py-2 pb-4 pt-2 text-center text-xs italic text-neutral-500" aria-live="polite">
                            {{ __('front::global.search_found_results', ['count' => $results->total()]) }}
                        </li>
                    @endif
                    @forelse ($results as $item)
                        @if (isset($item->url))
                            <li class="{{ $loop->last ? '' : 'border-b border-gray-200' }} flex items-start gap-4 py-3 transition hover:bg-blue-50"
                                tabindex="0" itemscope
                                itemtype="https://schema.org/{{ isset($item->formatted_price) ? 'Product' : 'Article' }}">
                                <a class="group flex w-full items-start gap-4 focus:outline-none"
                                   href="{{ $item->url }}" wire:navigate
                                   @if (isset($item->name) || isset($item->title)) title="{{ $item->name ?? $item->title }}" @endif
                                   itemprop="url">
                                    @if (isset($item->thumbnail_url))
                                        <img class="h-16 w-16 flex-shrink-0 rounded object-cover"
                                             src="{{ $item->thumbnail_url }}" alt="{{ $item->name ?? $item->title }}"
                                             loading="lazy" itemprop="image" />
                                    @endif
                                    <div class="flex-1 self-center">
                                        @if (isset($item->category_name))
                                            <div class="mb-1 text-[10px] uppercase text-blue-600" itemprop="genre">
                                                {{ $item->category_name }}
                                            </div>
                                        @endif
                                        <div class="font-semibold text-neutral-800 group-hover:text-blue-600"
                                             itemprop="name">
                                            {{ $item->name ?? ($item->title ?? '-') }}
                                        </div>
                                        @if (isset($item->subject))
                                            <p class="line-clamp-2 text-sm text-neutral-600" itemprop="about">
                                                {{ $item->subject }}</p>
                                        @endif
                                        @if (isset($item->description))
                                            <p class="line-clamp-2 text-sm text-neutral-600" itemprop="description">
                                                {{ $item->description }}</p>
                                        @endif
                                        @if (isset($item->formatted_price))
                                            <div class="mt-1 text-sm font-bold text-neutral-900" itemprop="offers"
                                                 itemscope itemtype="https://schema.org/Offer">
                                                <span itemprop="price">{{ $item->formatted_price }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @else
                            <li class="{{ $loop->last ? '' : 'border-b border-gray-200' }} flex items-start gap-4 py-3"
                                itemscope
                                itemtype="https://schema.org/{{ isset($item->formatted_price) ? 'Product' : 'Article' }}">
                                @if (isset($item->thumbnail_url))
                                    <img class="h-16 w-16 rounded object-cover" src="{{ $item->thumbnail_url }}"
                                         alt="{{ $item->name ?? $item->title }}" loading="lazy" itemprop="image" />
                                @endif
                                <div class="flex-1">
                                    <div class="font-semibold text-neutral-800" itemprop="name">
                                        {{ $item->name ?? ($item->title ?? '-') }}
                                    </div>
                                    @if (isset($item->category_name))
                                        <div class="mb-1 text-xs uppercase text-blue-600" itemprop="genre">
                                            {{ $item->category_name }}</div>
                                    @endif
                                    @if (isset($item->description))
                                        <div class="line-clamp-2 text-sm text-neutral-600" itemprop="description">
                                            {{ $item->description }}</div>
                                    @endif
                                    @if (isset($item->formatted_price))
                                        <div class="mt-1 text-sm font-bold text-neutral-900" itemprop="offers" itemscope
                                             itemtype="https://schema.org/Offer">
                                            <span itemprop="price">{{ $item->formatted_price }}</span>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @empty
                        <li class="py-4 text-center text-sm text-neutral-400" aria-live="polite">
                            <span class="max-w-3/4">
                                @if (empty($keyword))
                                    {{ __('front::global.search_empty_keyword') }}
                                @elseif ($tab === 'news')
                                    {{ __('front::global.news_not_found') }}
                                @elseif($tab === 'product')
                                    {{ __('front::global.product_not_found') }}
                                @elseif($tab === 'store')
                                    {{ __('front::global.store_not_found') }}
                                @else
                                    {{ __('front::global.search_no_results') }}
                                @endif
                            </span>
                        </li>
                    @endforelse
                    <template x-if="$store.infiniteScroll.loadingMore">
                        <li class="py-4 text-center text-xs text-neutral-400" aria-live="polite">
                            <span class="max-w-3/4">{{ __('front::global.search_loading') }}</span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </x-front::ui.modal.index>
</div>
