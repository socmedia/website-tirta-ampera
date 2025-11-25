@extends('front::layouts.master')

@section('title', $news->title)

@push('meta')
    <x-front::partials.meta :title="$news->title" :description="$news->subject" :keywords="$news->tags" :image="$news->thumbnail_url" />
@endpush

@push('style')
@endpush

@section('content')
    <section class="relative overflow-hidden">
        <!-- Blue Accent Blurs -->
        <div class="absolute right-[-40px] top-1/3 z-0 h-[220px] w-[220px] rounded-full bg-blue-100 blur-3xl"></div>
        <div class="absolute left-[-60px] top-[180px] z-0 h-[200px] w-[200px] rounded-full bg-blue-200 blur-3xl"></div>
        <div class="absolute bottom-[-100px] left-[40px] z-0 h-[300px] w-[300px] rounded-full bg-blue-50 blur-3xl"></div>
        <div class="container relative z-10">
            <div class="grid gap-y-8 lg:grid-cols-3 lg:gap-x-8 lg:gap-y-0">
                <!-- Content -->
                <div class="py-20 lg:col-span-2">
                    <div class="py-8 lg:pe-8">
                        <article class="space-y-5 lg:space-y-8" itemscope itemtype="https://schema.org/Article">
                            <header>
                                <h1 class="mb-2 text-3xl font-bold lg:text-5xl" itemprop="headline">
                                    {{ $news->title }}
                                </h1>
                                <div class="flex items-center gap-x-5">
                                    @if ($news->category_name)
                                        <a class="focus:outline-hidden inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-800 hover:bg-gray-200 focus:bg-gray-200 sm:px-4 sm:py-2 sm:text-sm"
                                           href="{{ route('front.news.index', ['category' => $news->category_slug]) }}"
                                           rel="category" itemprop="articleSection">
                                            {{ $news->category_name }}
                                        </a>
                                    @endif
                                    <time class="text-xs text-gray-800 sm:text-sm" itemprop="datePublished"
                                          datetime="{{ $news->published_at ?? $news->created_at }}">
                                        {{ $news->published_at ? $news->formatted_published_at : $news->formatted_created_at }}
                                    </time>
                                </div>
                            </header>

                            @if ($news->thumbnail_url)
                                <figure class="mb-6" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                    <img class="mx-auto max-h-96 w-full rounded-xl object-cover"
                                         src="{{ $news->thumbnail_url }}" alt="{{ $news->title }}" itemprop="url">
                                    @if ($news->caption)
                                        <figcaption class="mt-3 text-center text-sm text-gray-500" itemprop="caption">
                                            {{ $news->caption }}
                                        </figcaption>
                                    @endif
                                </figure>
                            @endif

                            <div class="prose max-w-3xl text-gray-800" itemprop="articleBody">
                                {!! $news->content !!}
                            </div>

                            <footer>
                                <div
                                     class="mt-8 flex flex-col gap-y-5 lg:flex-row lg:items-center lg:justify-between lg:gap-y-0">
                                    <!-- Badges/Tags -->
                                    <div>
                                        @foreach ($news->tags_array ?? [] as $tag)
                                            <a class="focus:outline-hidden m-0.5 inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-2 text-sm text-gray-800 hover:bg-gray-200 focus:bg-gray-200"
                                               href="{{ route('front.news.index', ['tag' => $tag]) }}" rel="tag"
                                               itemprop="keywords">
                                                #{{ $tag }}
                                            </a>
                                        @endforeach
                                    </div>
                                    <!-- End Badges/Tags -->
                                </div>
                            </footer>
                        </article>
                    </div>
                </div>
                <!-- End Content -->

                <!-- Sidebar -->
                <div
                     class="py-20 lg:col-span-1 lg:h-full lg:w-full lg:bg-gradient-to-r lg:from-gray-50 lg:via-transparent lg:to-transparent">
                    <div class="sticky start-0 top-20 py-8 lg:ps-8">
                        <livewire:front::news.related :exceptId="$news->id" :tags="$news->tags" :category="$news->category_id" />
                    </div>
                </div>
                <!-- End Sidebar -->
            </div>
        </div>
    </section>
@endsection
