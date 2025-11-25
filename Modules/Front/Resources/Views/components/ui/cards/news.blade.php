@props(['post'])

<a class="group block" href="{{ route('front.news.show', ['slug' => $post->slug]) }}" wire:navigate>
    <div
         class="group-hover:border-primary-300 relative h-full overflow-hidden rounded-lg border border-gray-200 border-opacity-60 shadow-sm transition-all duration-150 group-hover:shadow-lg">
        <img class="w-full object-cover object-center md:h-36 lg:h-48"
             src="{{ $post->thumbnail_url ?? getSetting('thumbnail_3_2') }}" alt="{{ $post->title }}" loading="lazy"
             onerror="this.src='{{ getSetting('thumbnail_3_2') }}'; this.parentElement.classList.add('bg-neutral-200')" />
        @if ($post->category_name)
            <span class="badge soft-secondary absolute left-2 top-2">
                {{ $post->category_name }}
            </span>
        @endif
        <div class="space-y-2 p-4">
            <div class="flex flex-wrap items-center gap-2 text-xs">
                @if ($post->formatted_published_at)
                    <span class="inline-flex items-center py-1 pr-3 leading-none text-gray-400">
                        <i class="bx bx-calendar mr-1"></i>
                        {{ $post->formatted_published_at }}
                    </span>
                @endif

                @if (isset($post->number_of_views))
                    <span class="ml-auto inline-flex items-center leading-none text-gray-400">
                        <i class="bx bx-eye mr-1"></i>
                        {{ $post->formatted_number_of_views }}
                    </span>
                @endif

                @if (isset($post->number_of_shares))
                    <span class="inline-flex items-center leading-none text-gray-400">
                        <i class="bx bx-share mr-1"></i>
                        {{ $post->formatted_number_of_shares }}
                    </span>
                @endif
            </div>

            <h1 class="title-font group-hover:text-primary-700 mb-3 line-clamp-2 text-lg font-medium leading-snug text-gray-900 transition-colors"
                title="{{ $post->title }}">
                {{ $post->title }}
            </h1>

            <p class="mb-3 line-clamp-2 leading-snug text-gray-600">
                {{ $post->subject }}
            </p>
        </div>
    </div>
</a>
