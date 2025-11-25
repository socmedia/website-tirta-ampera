<div class="flex flex-col gap-8 lg:flex-row">
    <!-- Sidebar Filter -->
    <aside class="w-full space-y-6 lg:w-1/4">
        <div class="card space-y-4 p-6">
            <div>
                <h4 class="font-semibold">Cari Berita</h4>
                <p class="mb-3 text-sm text-neutral-500">
                    Cari berita terkini atau topik tertentu yang ingin Anda baca di sini.
                </p>
                <x-front::ui.forms.search placeholder="Cari berita yang Anda inginkan..." />
            </div>

            <hr class="my-2 border-t border-neutral-200" />

            <div>
                <h4 class="font-semibold">Kategori Berita</h4>
                <p class="mb-3 text-sm text-neutral-500">
                    Pilih kategori untuk memfilter berita.
                </p>
                <div class="space-y-3">
                    @foreach ($categories as $category)
                        <label class="flex cursor-pointer select-none items-center space-x-2">
                            <input class="form-checkbox" name="selectedCategories[]" type="checkbox"
                                   value="{{ $category->id }}" wire:model.live="selectedCategories">
                            <span class="text-sm text-neutral-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>

    <!-- Produk -->
    <div class="w-full lg:w-3/4">
        <!-- Filter header -->
        <div class="mb-6 flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
            <!-- Kanan: Sort & Reset -->
            <div class="ml-auto flex flex-wrap items-center gap-3 sm:justify-end sm:gap-4">
                <!-- Sort by -->
                <div class="inline-flex items-center gap-2 text-sm text-neutral-600 sm:gap-2">
                    <span class="whitespace-nowrap">{{ getContent('news.filters.sort.label') }}</span>
                    <select class="form-select rounded-full text-sm" wire:model.lazy="sortOption">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title-asc">Judul (A-Z)</option>
                        <option value="title-desc">Judul (Z-A)</option>
                    </select>
                </div>

                <!-- Reset Filter -->
                @if ($hasActiveFilter)
                    <div class="flex items-center gap-3">
                        <button class="link-primary text-sm" type="button" wire:click="resetFilters">
                            Reset Filter
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Produk grid -->

        <!-- Grid -->
        <div class="mb-12 grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-3">
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
