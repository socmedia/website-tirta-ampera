<div>
    <div class="mx-auto mb-8 w-full max-w-lg">
        <!-- First row: Search -->
        <div class="mb-4 w-full">
            <x-front::ui.forms.search class="w-full px-8 py-4" placeholder="Cari berita yang Anda inginkan..." />
        </div>
        <!-- Second row: Centered Filters with left labels, right filters, and narrower form -->
        <div
             class="flex w-full flex-col items-center justify-center gap-3 md:flex-row md:items-center md:justify-center md:gap-5">
            <!-- Centered Filters -->
            <div class="flex flex-row items-center justify-center gap-3 md:gap-5">
                <!-- Sort by -->
                <div class="inline-flex items-center gap-2 text-sm text-neutral-600">
                    <label class="whitespace-nowrap font-medium text-neutral-700" for="sortby">Urutkan:</label>
                    <select class="form-select w-36 rounded-full text-sm md:w-44" id="sortby"
                            wire:model.lazy="sortOption">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title-asc">Judul (A-Z)</option>
                        <option value="title-desc">Judul (Z-A)</option>
                    </select>
                </div>
                <!-- Filter by Category -->
                <div class="inline-flex items-center gap-2 text-sm text-neutral-600">
                    <label class="whitespace-nowrap font-medium text-neutral-700"
                           for="selectedCategory">Kategori:</label>
                    <select class="form-select w-36 rounded-full text-sm md:w-44" id="selectedCategory"
                            wire:model.lazy="selectedCategory">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Reset Filter -->
                @if ($hasActiveFilter)
                    <div class="flex flex-shrink-0 items-center gap-3">
                        <button class="link-primary text-sm" type="button" wire:click="resetFilters">
                            Reset Filter
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="w-full">
        <!-- Grid with 4 columns on desktop -->
        <div class="mb-12 grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($news as $post)
                <x-front::ui.cards.news :post="$post" />
            @empty
                <x-front::partials.empty-statement title="{{ getContent('news.notfound.title') }}" icon="bx-news"
                                                   :description="getContent('news.notfound.desc')" />
            @endforelse
        </div>

        <div class="flex justify-between pb-8">
            <x-front::partials.page-number :paginator="$news" label="{{ getContent('news.result_label') }}" />

            {{ $news->onEachSide(1)->links('livewire::tailwind') }}
        </div>
    </div>
</div>
