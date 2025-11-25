<section class="border-t border-neutral-200 bg-neutral-50 pt-24">
    <div class="">
        <div class="container py-12 lg:py-16">
            <div class="md:grid md:grid-cols-5 md:gap-4">
                <!-- Logo & Tagline -->
                <div class="mb-12 flex flex-col items-start md:mb-0">
                    <a class="mb-4 block" href="{{ url('/') }}" wire:navigate>
                        <img class="h-14" src="{{ getSetting('logo') }}" alt="Logo" />
                    </a>
                    <span
                          class="bg-gradient-to-r from-sky-600 to-emerald-400 bg-clip-text text-base font-semibold italic text-transparent">
                        {{ getSetting('site_tagline') }}
                    </span>
                </div>
                @foreach ($data['sections'] as $section)
                    <div @if (!$loop->first) class="mt-12 md:mt-0" @endif>
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-sky-600">
                            {{ $section['title'] }}
                        </h3>
                        <ul class="mt-4 space-y-2" role="list">
                            @foreach ($section['items'] as $item)
                                <li>
                                    @if (isset($item['external_link']))
                                        <a class="text-sm font-normal text-neutral-500 hover:text-neutral-900"
                                           href="{{ $item['external_link'] }}" target="_blank" rel="noopener">
                                            {{ $item['label'] }}
                                        </a>
                                    @else
                                        @php
                                            if (isset($item['params']) && is_array($item['params'])) {
                                                $routeParams = $item['params'];
                                            }
                                        @endphp
                                        <a class="text-sm font-normal text-neutral-500 hover:text-neutral-900"
                                           href="{{ route($item['route'], $routeParams ?? null) }}" wire:navigate>
                                            {{ $item['label'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                <!-- Contact Info -->
                <div class="mt-12 md:mt-0">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-sky-600">
                        Kontak
                    </h3>
                    <ul class="mt-4 space-y-4" role="list">
                        @foreach ($contact as $item)
                            @if (!empty($item['value']))
                                <li class="flex items-start gap-2">
                                    <div>
                                        <span class="block break-words text-sm font-semibold text-neutral-600">
                                            {{ $item['label'] }}
                                        </span>
                                        <span class="block break-words text-sm font-normal text-neutral-500">
                                            @if ($item['label'] == 'Email' || $item['label'] == 'Email Support')
                                                <a class="hover:underline"
                                                   href="mailto:{{ $item['value'] }}">{{ $item['value'] }}</a>
                                            @elseif ($item['label'] == 'WhatsApp' && !empty(getSetting('contact_whatsapp_link')))
                                                <a class="hover:underline"
                                                   href="{{ getSetting('contact_whatsapp_link') }}" target="_blank"
                                                   rel="noopener">
                                                    {{ $item['value'] }}
                                                </a>
                                            @elseif ($item['label'] == 'Telepon' || $item['label'] == 'Info Pelayanan' || $item['label'] == 'Fax')
                                                <a class="hover:underline"
                                                   href="tel:{{ preg_replace('/[^0-9+]/', '', $item['value']) }}">{{ $item['value'] }}</a>
                                            @else
                                                {{ $item['value'] }}
                                            @endif
                                        </span>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-neutral-100 py-12">
        <div class="container md:flex md:items-center md:justify-between">
            <div class="mb-8 flex justify-center space-x-6 md:order-last md:mb-0">
                @foreach ($socials as $social)
                    <a class="text-neutral-400 hover:text-neutral-500" href="{{ $social['url'] }}" target="_blank"
                       rel="noopener">
                        <span class="sr-only">{{ $social['label'] ?? 'Social link' }}</span>
                        @if (isset($social['icon_svg']))
                            {!! $social['icon_svg'] !!}
                        @else
                            <i class="{{ $social['icon'] }} text-lg"></i>
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="mt-8 text-center md:order-1 md:mt-0 md:text-left">
                <span class="mt-2 text-sm font-light text-neutral-500">
                    {{ getSetting('copyright') }}
                </span>
                @if (!empty($links))
                    <ul class="mt-4 flex flex-wrap justify-center gap-4 md:mt-0 md:justify-start">
                        @foreach ($links as $link)
                            <li class="whitespace-nowrap underline hover:text-sky-600">
                                <a href="{{ route($link['route']) }}" wire:navigate>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>
