<!-- Section 3: Sejarah & Milestone (Responsive Timeline Grid) -->
<section class="py-10 sm:py-16 lg:py-24">
    <x-front::partials.section-title class="mb-8 sm:mb-16" :title="getContent('about.milestone.title')" :content="getContent('about.milestone.description')" />

    <div class="swiper milestone-swiper relative" x-data x-init="$store.swiper.init({
        key: 'milestone',
        selector: $el,
        options: {
            slidesPerView: 3.5,
            spaceBetween: 30,
            loop: true,
            effect: 'slide',
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.custom-swiper-pagination',
                clickable: true,
            },
            fadeEffect: {
                crossFade: true
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.5,
                    spaceBetween: 8,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3.5,
                    spaceBetween: 30,
                }
            }
        }
    })">
        <div class="swiper-wrapper py-14">
            @foreach ($sliders as $milestone)
                <div class="swiper-slide relative">
                    <div class="flex items-start gap-4">
                        <div>
                            <div class="grid size-14 place-items-center rounded-full bg-sky-100 text-sky-600">
                                <i class="{{ $milestone->desktop_media_path }} text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <span class="mb-1 block text-xs font-semibold uppercase text-sky-600 sm:text-sm">
                                {{ $milestone['heading'] ?? '' }}
                            </span>
                            <h3 class="mb-1 text-lg font-bold text-gray-900 sm:mb-2 sm:text-xl">
                                {{ $milestone['sub_heading'] ?? '' }}
                            </h3>
                            <p class="text-sm text-gray-600 sm:text-base">
                                {{ $milestone['description'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div
             class="bg-linear-to-l pointer-events-none absolute right-0 top-0 z-10 h-full w-24 from-white to-transparent sm:w-40 lg:w-56">
        </div>
        <div class="custom-swiper-pagination absolute bottom-0 left-0 right-0 z-20 flex justify-center gap-1">
        </div>
    </div>

</section>
