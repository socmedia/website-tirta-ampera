<section class="bg-cover bg-center pb-16 pt-32 md:py-24"
         style="background-image: url('{{ asset('assets/images/bg_promo.png') }}');">
    <div class="container">
        <div class="mb-10 text-center">
            <h2 class="mb-2 text-3xl font-bold leading-snug text-neutral-800 md:text-5xl">
                {{ getContent('homepage.special.heading') }}</h2>
            <p class="text-neutral-500"> {{ getContent('homepage.special.description') }}</p>
        </div>
        <div class="swiper promo-swiper relative" x-data x-init="$store.swiper.init({
            key: 'promo',
            selector: $el,
            options: {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: true,
                effect: 'slide',
                autoplay: {
                    delay: 5000,
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
                        slidesPerView: 1.3,
                        spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    }
                }
            }
        })">
            <div class="swiper-wrapper">
                @foreach ($promoSlider as $promo)
                    <div class="swiper-slide flex items-center justify-center py-4">
                        <div
                             class="aspect-square m-2 w-full overflow-hidden rounded-lg bg-sky-50 ring-1 ring-sky-200 transition hover:bg-sky-100 hover:shadow-lg">
                            <img class="h-full w-full object-cover transition hover:scale-105"
                                 src="{{ $promo['thumbnail'] }}" alt="{{ $promo['heading'] }}" loading="lazy" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Swiper Pagination -->
        <div
             class="custom-swiper-pagination absolute !bottom-10 left-0 right-0 z-20 flex justify-center gap-1 sm:gap-2">
        </div>
    </div>
</section>
