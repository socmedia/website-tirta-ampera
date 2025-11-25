<section class="bg-white py-20">
    <div
         class="flex flex-col-reverse justify-between gap-32 rounded-2xl bg-gradient-to-r from-sky-600 to-blue-700 px-8 lg:flex-row xl:px-24">
        <div class="relative flex w-full items-end justify-center overflow-hidden lg:w-2/6">
            <img class="absolute left-1/2 top-12 z-10 -mb-12 w-full max-w-[320px] -translate-x-1/2 rounded-t-3xl object-cover xl:top-24"
                 src="{{ asset('assets/images/mockup/mockup-portrait.png') }}" alt="Mockup aplikasi Tirta Amperaku" />
        </div>
        <div class="flex w-full flex-col justify-center py-12 lg:w-2/3 xl:py-24">
            <h2 class="font-manrope mb-7 text-center text-4xl font-extrabold text-white md:text-5xl lg:text-left">
                {{ getContent('global.cta.apps.title') }}
            </h2>
            <p class="mb-4 text-center text-lg leading-8 text-white lg:text-left">
                {{ getContent('global.cta.apps.desc') }}
            </p>
            <div class="mb-8 flex flex-wrap justify-center gap-2 lg:justify-start">
                <span
                      class="inline-flex items-center gap-1 rounded-full bg-lime-400/20 px-3 py-1 text-xs font-semibold text-lime-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                    Mobile Experience
                </span>
                <span
                      class="inline-flex items-center gap-1 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/80">
                    Android &amp; iOS
                </span>
            </div>
            <div class="flex flex-col items-center justify-center gap-7 md:flex-row lg:justify-start">
                <a class="cursor-pointer" href="{{ getContent('global.cta.apps.android_url') }}" target="_blank"
                   rel="noopener">
                    <img class="h-12"
                         src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                         alt="Get it on Google Play" />
                </a>
                <a class="cursor-pointer" href="{{ getContent('global.cta.apps.ios_url') }}" target="_blank"
                   rel="noopener">
                    <img class="h-12"
                         src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                         alt="Download on the App Store" />
                </a>
            </div>
        </div>
    </div>
</section>
