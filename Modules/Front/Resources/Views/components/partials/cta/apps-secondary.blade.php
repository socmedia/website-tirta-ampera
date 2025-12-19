<section class="relative overflow-hidden bg-slate-50 py-24 lg:py-32">
    <div class="container mx-auto max-w-7xl px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            <div class="order-2 flex flex-col items-start lg:order-1">
                <h2 class="mb-4 text-3xl font-bold leading-[0.9] text-slate-900 md:text-4xl lg:text-5xl">
                    {{ getContent('global.cta.apps.secondary.title') }}
                </h2>
                <p class="mb-6 text-base text-slate-600">
                    {{ getContent('global.cta.apps.secondary.lead') }}
                </p>
                <p class="mb-8 text-lg leading-relaxed text-slate-600">
                    {!! getContent('global.cta.apps.secondary.desc') !!}
                </p>

                <ul class="mb-10 space-y-4">
                    @foreach (getContent('global.cta.apps.secondary.features') ?? [] as $i => $feature)
                        <li class="flex items-start gap-4">
                            <div
                                 class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-600 text-white">
                                @if ($i === 5)
                                    <i class="bx bx-dots-horizontal-rounded text-lg"></i>
                                @else
                                    <i class="bx bx-check text-lg"></i>
                                @endif
                            </div>
                            <span class="text-slate-700">{!! $feature !!}</span>
                        </li>
                    @endforeach
                </ul>

                @php
                    $androidUrl = getContent('global.cta.apps.android_url');
                    $iosUrl = getContent('global.cta.apps.ios_url');
                @endphp

                <div class="flex flex-col gap-4 sm:flex-row">
                    {{-- Android Button --}}
                    @if ($androidUrl)
                        <a class="transition hover:-translate-y-1 hover:opacity-80" href="{{ $androidUrl }}"
                           target="_blank" rel="noopener">
                            <img class="h-12"
                                 src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                 alt="Get it on Google Play" />
                        </a>
                    @else
                        <button class="cursor-pointer border-0 bg-transparent p-0 transition hover:-translate-y-1 hover:opacity-80"
                                type="button"
                                x-on:click="$store.ui.notify('Maaf, aplikasi belum tersedia di Google Play Store. Nantikan kehadirannya segera, ya!')">
                            <img class="h-12"
                                 src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                 alt="Get it on Google Play (Belum Tersedia)" />
                        </button>
                    @endif

                    {{-- iOS Button --}}
                    @if ($iosUrl)
                        <a class="transition hover:-translate-y-1 hover:opacity-80" href="{{ $iosUrl }}"
                           target="_blank" rel="noopener">
                            <img class="h-12"
                                 src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                 alt="Download on the App Store" />
                        </a>
                    @else
                        <button class="cursor-pointer border-0 bg-transparent p-0 transition hover:-translate-y-1 hover:opacity-80"
                                type="button"
                                x-on:click="$store.ui.notify('Maaf, aplikasi belum tersedia di App Store. Nantikan kehadirannya segera, ya!')">
                            <img class="h-12"
                                 src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                 alt="Download on the App Store (Belum Tersedia)" />
                        </button>
                    @endif
                </div>
            </div>

            <div class="relative order-1 flex justify-center lg:order-2">
                <div
                     class="absolute bottom-8 left-1/2 z-0 h-10 w-2/3 -translate-x-1/2 translate-y-1/3 rotate-6 rounded-full bg-slate-300/80 blur-2xl lg:h-24 lg:w-1/2">
                </div>

                <img class="relative z-10 w-full max-w-sm" src="{{ asset('assets/images/mockup/mockup-left.png') }}"
                     alt="Mockup aplikasi Tirta Amperaku" />
            </div>
        </div>
    </div>
</section>
