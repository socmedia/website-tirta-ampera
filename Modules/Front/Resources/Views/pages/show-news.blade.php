@extends('front::layouts.master')

@section('title', $news->title)

@push('meta')
    <x-front::partials.meta :title="$news->title" :description="$news->subject" :keywords="$news->tags" :image="$news->thumbnail_url" />
@endpush

@push('style')
@endpush

@section('content')
    <section class="relative bg-white py-32">

        <div class="container relative z-10">
            <div class="absolute inset-0 z-0 opacity-[0.4]"
                 style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 32px 32px;">
            </div>

            <div
                 class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-sky-100 opacity-50 mix-blend-multiply blur-3xl filter">
            </div>

            <div class="flex flex-col gap-10 lg:flex-row lg:gap-16">

                <div class="w-full lg:w-3/4">
                    <article itemscope itemtype="https://schema.org/Article">

                        {{-- 1. HEADER SECTION: Category, Title, Meta --}}
                        <header class="mb-10 text-center md:text-left">
                            @if ($news->category_name)
                                <a class="mb-6 inline-flex items-center gap-1.5 rounded-full bg-sky-100 px-4 py-1.5 text-sm font-bold text-sky-700 transition hover:bg-sky-200"
                                   href="{{ route('front.news.index', ['category' => $news->category_slug]) }}"
                                   rel="category" itemprop="articleSection">
                                    {{ $news->category_name }}
                                </a>
                            @endif

                            <h1 class="mb-6 text-3xl font-extrabold leading-tight tracking-tight text-neutral-900 md:text-5xl"
                                itemprop="headline">
                                {{ $news->title }}
                            </h1>

                            <div
                                 class="flex flex-wrap items-center justify-center gap-4 text-sm text-neutral-600 md:justify-start">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor"
                                         stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    <time itemprop="datePublished"
                                          datetime="{{ $news->published_at ?? $news->created_at }}">
                                        {{ $news->published_at ? $news->formatted_published_at : $news->formatted_created_at }}
                                    </time>
                                </span>
                                @if ($news->reading_time)
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor"
                                             stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $news->reading_time }} min read
                                    </span>
                                @endif
                            </div>
                        </header>

                        {{-- 2. FEATURED IMAGE --}}
                        @if ($news->thumbnail_url)
                            <figure class="mb-12" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                {{-- Shadow dihapus, border radius diperhalus --}}
                                <img class="h-[300px] w-full rounded-2xl object-cover object-center md:h-[500px]"
                                     src="{{ $news->thumbnail_url }}" alt="{{ $news->title }}" itemprop="url">
                                @if ($news->caption)
                                    <figcaption class="mt-3 text-center text-sm italic text-neutral-500 md:text-left"
                                                itemprop="caption">
                                        {{ $news->caption }}
                                    </figcaption>
                                @endif
                            </figure>
                        @endif

                        {{-- 3. CONTENT BODY --}}
                        <div>
                            @if ($news->subject)
                                <div class="mb-8 text-lg font-medium leading-relaxed text-neutral-700"
                                     itemprop="description">
                                    {{ $news->subject }}
                                </div>
                            @endif

                            <div class="prose prose-lg prose-slate max-w-none leading-relaxed prose-a:text-sky-600 hover:prose-a:text-sky-700 prose-img:rounded-2xl"
                                 itemprop="articleBody">
                                {!! $news->content !!}
                            </div>

                            <footer class="mt-12 rounded-md border-t border-neutral-100 bg-neutral-50 p-4 lg:p-8">
                                <div class="mb-4">
                                    <span class="text-sm font-semibold text-neutral-700">
                                        Tags:
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    @if (!empty($news->tags_array))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($news->tags_array as $tag)
                                                <a class="btn btn-sm soft-primary"
                                                   href="{{ route('front.news.index', ['tag' => $tag]) }}" wire:navigate
                                                   rel="tag" itemprop="keywords">
                                                    #{{ $tag }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </footer>
                        </div>
                    </article>
                </div>

                <div class="w-full lg:w-1/4">
                    <div class="sticky top-24 pl-2">
                        <livewire:front::news.related :exceptId="$news->id" :tags="$news->tags" :category="$news->category_id" />
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
