<div class="mx-auto max-w-[85rem] px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold text-gray-800 lg:text-4xl">
            {{ getContent('global.news.heading') }}
        </h2>
        <p class="mt-3 text-lg text-gray-600">
            {{ getContent('global.news.description') }}
        </p>
    </div>

    <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse($news as $item)
            <x-front::ui.cards.news :post="$item" />
        @empty
            <div class="col-span-3 py-8 text-center text-neutral-400">
                {{ __('Belum ada berita terbaru.') }}
            </div>
        @endforelse
    </div>
    <div class="mt-12 text-center">
        <a class="inline-flex items-center justify-center gap-x-2 rounded-lg border border-transparent bg-sky-600 px-4 py-3 text-sm font-medium text-white hover:bg-sky-700 focus:bg-sky-700"
           href="{{ route('front.news.index') }}" wire:navigate>
            {{ getContent('global.news.cta') }}
            <i class="bx bx-chevron-right text-lg"></i>
        </a>
    </div>
</div>
