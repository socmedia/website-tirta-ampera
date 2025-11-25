<div class="relative z-10">
    <div class="mb-8 flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
        <div>
            <h2 class="mb-2 text-2xl font-bold leading-snug text-neutral-800 md:text-3xl">
                {{ __('front::global.related_news') }}
            </h2>
            <p class="max-w-xl text-neutral-500">
                {{ __('front::global.related_news_description') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($news as $item)
            <article class="focus:outline-hidden group flex items-center gap-x-6" itemscope
                     itemtype="https://schema.org/Article">
                <a class="flex w-full items-center gap-x-6 rounded-lg bg-blue-50 transition-colors hover:bg-blue-100 focus:bg-blue-200"
                   href="{{ route('front.news.show', $item->slug) }}" itemprop="url">
                    @if ($item->thumbnail_url)
                        <div class="relative size-20 shrink-0 overflow-hidden rounded-lg">
                            <img class="absolute start-0 top-0 size-full rounded-lg object-cover"
                                 src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" loading="lazy"
                                 itemprop="image">
                        </div>
                    @endif
                    <div class="grow">
                        <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 group-focus:text-blue-600"
                              itemprop="headline">
                            {{ $item->title }}
                        </span>
                        <div class="mt-1 text-xs text-gray-500">
                            <time itemprop="datePublished" datetime="{{ $item->published_at ?? $item->created_at }}">
                                {{ $item->formatted_published_at }}
                            </time>
                        </div>
                    </div>
                </a>
            </article>
        @empty
            <div class="col-span-4 py-8 text-neutral-400">
                {{ __('front::global.related_news_not_found') }}
            </div>
        @endforelse
    </div>
</div>
