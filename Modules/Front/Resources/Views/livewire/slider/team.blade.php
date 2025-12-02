<div class="container bg-white py-20">
    <div class="flex flex-col items-start gap-3 pb-20 md:flex-row">
        <div class="md:w-1/3">
            <p class="mb-2 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-sky-600">
                <span class="inline-block h-0.5 w-6 bg-sky-600"></span>
                {{ getContent('about.organization.board_of_commissioners.title') }}
            </p>
        </div>
        <div class="max-w-2xl leading-relaxed text-neutral-600 md:w-2/3">
            <p>
                {{ getContent('about.organization.board_of_commissioners.subtitle') }}
            </p>
        </div>
    </div>

    <div class="">
        <div class="swiper team-swiper !p-2" x-data x-init="$store.swiper.init({
            key: 'teamSlider',
            selector: $el,
            options: {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1.3,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                }
            }
        })">
            <div class="swiper-wrapper py-6">
                @foreach ($sliders as $member)
                    <div class="swiper-slide">
                        <div class="overflow-hidden rounded-xl bg-white shadow-md ring-2 ring-gray-200">
                            <div class="aspect-square relative w-full">
                                <!-- Background decoration -->
                                <div class="absolute inset-0">
                                    <div
                                         class="absolute -right-10 -top-10 z-0 h-40 w-40 rounded-full bg-sky-200 opacity-30 blur-2xl">
                                    </div>
                                    <div
                                         class="w-50 h-50 absolute -bottom-10 -left-10 z-0 rounded-full bg-sky-400 opacity-40 blur-2xl">
                                    </div>
                                </div>

                                <img class="z-10 h-full w-full object-cover" src="{{ asset($member->image_url) }}"
                                     alt="{{ $member->heading }}" loading="lazy" {{-- onerror="this.onerror=null;this.src='{{ asset('assets/images/default/avatar.png') }}';" --}} />
                                <div
                                     class="absolute bottom-0 left-0 right-0 z-20 bg-gradient-to-t from-white via-sky-50/80 to-transparent p-10 text-center">
                                    <h2
                                        class="text-shadow-2xs text-xl font-semibold uppercase tracking-wide text-sky-800">
                                        {{ strtoupper($member->heading) }}
                                    </h2>
                                    <p class="text-sm text-sky-600">{{ $member->sub_heading ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
