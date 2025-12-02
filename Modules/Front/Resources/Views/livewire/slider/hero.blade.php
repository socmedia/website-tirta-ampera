<div>
    {{-- Hero Section with Swiper --}}
    <section class="relative flex max-h-screen w-full items-center justify-center overflow-hidden bg-black/70 p-0">
        <div class="swiper hero-swiper h-[60vh] w-full md:h-[90vh]" x-data x-init="$store.swiper.init({
            key: 'heroSlider',
            selector: $el,
            options: {
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
                breakpoints: {}
            }
        })">
            <div class="swiper-wrapper">
                @foreach ($heroSlides as $slide)
                    <div class="swiper-slide relative flex h-full w-full items-center justify-center"
                         style="background-image: url('{{ $slide['thumbnail'] }}'); background-size: cover; background-position: center;">

                        <div class="absolute inset-0 bg-gradient-to-b from-black/80 to-black/50"></div>

                        <div class="relative z-10 flex h-full w-full items-center py-16 sm:py-20 md:py-32">
                            <div class="container">
                                <div
                                     class="text-shadow-2xs mb-4 flex items-center text-xs font-medium text-sky-600 sm:text-xl">
                                    <span
                                          class="mr-2 hidden h-0.5 w-6 border-l-2 border-sky-200 bg-sky-600 md:inline-block"></span>
                                    {{ $slide['sub_heading'] }}
                                </div>

                                <h1
                                    class="font-montserrat max-w-2xl text-2xl font-extrabold leading-tight text-white sm:text-3xl md:text-5xl">
                                    {{ $slide['heading'] }}
                                </h1>

                                <p class="mt-4 max-w-md text-sm text-gray-200 sm:text-base md:text-lg">
                                    {{ $slide['description'] }}
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            {{-- Swiper Pagination & Navigation --}}
            <div
                 class="custom-swiper-pagination absolute !bottom-10 left-0 right-0 z-20 flex justify-center gap-1 sm:gap-2">
            </div>
            {{-- <button
                class="flex absolute left-2 top-1/2 z-20 justify-center items-center w-9 h-9 text-white rounded-full transition -translate-y-1/2 custom-swiper-button-prev sm:left-4 sm:h-12 sm:w-12 bg-black/40 hover:bg-black/70"
                type="button">
                <i class="text-2xl bx bx-chevron-left sm:text-3xl"></i>
            </button>
            <button
                class="flex absolute right-2 top-1/2 z-20 justify-center items-center w-9 h-9 text-white rounded-full transition -translate-y-1/2 custom-swiper-button-next sm:right-4 sm:h-12 sm:w-12 bg-black/40 hover:bg-black/70"
                type="button">
                <i class="text-2xl bx bx-chevron-right sm:text-3xl"></i>
            </button> --}}
        </div>
    </section>
</div>
