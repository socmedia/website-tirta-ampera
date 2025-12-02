<section class="border-t border-neutral-200 bg-white pt-16 lg:pt-20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-8">

            <div class="flex flex-col items-start lg:col-span-4">
                <a class="mb-5 block" href="{{ url('/') }}" wire:navigate>
                    <img class="h-14 w-auto object-contain" src="{{ getSetting('logo') }}" alt="Logo" />
                </a>
                <div class="space-y-2">
                    @foreach ($contact['main'] as $item)
                        <div class="text-sm text-neutral-500">
                            <p class="text-xs font-semibold text-sky-600">{{ $item['label'] }}</p>
                            <span>
                                @if ($item['label'] === 'Telp.' && !empty($item['value']))
                                    <a class="hover:text-sky-600 hover:underline"
                                       href="tel:{{ preg_replace('/[^0-9+]/', '', $item['value']) }}">
                                        {{ $item['value'] }}
                                    </a>
                                @elseif ($item['label'] === 'Fax' && !empty($item['value']))
                                    <a class="hover:text-sky-600 hover:underline"
                                       href="tel:{{ preg_replace('/[^0-9+]/', '', $item['value']) }}">
                                        {{ $item['value'] }}
                                    </a>
                                @else
                                    {{ $item['value'] }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-5 lg:pl-8">
                @foreach ($data['sections'] as $section)
                    <div>
                        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-neutral-900">
                            {{ $section['title'] }}
                        </h3>
                        <ul class="space-y-2">
                            @foreach ($section['items'] as $item)
                                <li>
                                    @if (isset($item['external_link']))
                                        <a class="text-sm font-medium text-neutral-500 transition hover:text-sky-600"
                                           href="{{ $item['external_link'] }}" target="_blank" rel="noopener">
                                            {{ $item['label'] }}
                                        </a>
                                    @else
                                        @php
                                            $routeParams =
                                                isset($item['params']) && is_array($item['params'])
                                                    ? $item['params']
                                                    : null;
                                        @endphp
                                        <a class="text-sm font-medium text-neutral-500 transition hover:text-sky-600"
                                           href="{{ route($item['route'], $routeParams) }}" wire:navigate>
                                            {{ $item['label'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-3">
                <h3 class="mb-6 text-sm font-bold uppercase tracking-wider text-neutral-900">
                    Bantuan
                </h3>
                <ul class="space-y-2">
                    @foreach ($contact['help'] as $item)
                        @if (!empty($item['value']))
                            <li>
                                <p class="text-xs font-semibold text-sky-600">{{ $item['label'] }}</p>

                                <div class="text-sm leading-relaxed text-neutral-500">
                                    @if ($item['label'] == 'Email' || $item['label'] == 'Email Support')
                                        <a class="hover:text-sky-600 hover:underline"
                                           href="mailto:{{ $item['value'] }}">{{ $item['value'] }}</a>
                                    @elseif ($item['label'] == 'WhatsApp' && !empty(getSetting('contact_whatsapp_link')))
                                        <a class="hover:text-sky-600 hover:underline"
                                           href="{{ getSetting('contact_whatsapp_link') }}" target="_blank"
                                           rel="noopener">{{ $item['value'] }}</a>
                                    @elseif ($item['label'] == 'Telepon' || $item['label'] == 'Info Pelayanan')
                                        <a class="hover:text-sky-600 hover:underline"
                                           href="tel:{{ preg_replace('/[^0-9+]/', '', $item['value']) }}">{{ $item['value'] }}</a>
                                    @else
                                        {!! nl2br(e($item['value'])) !!}
                                    @endif

                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-16 border-t border-neutral-100 bg-neutral-50 py-8">
        <div class="container mx-auto flex flex-col items-center justify-between px-6 md:flex-row">
            <span class="text-center text-sm text-neutral-500 md:text-left">
                {{ getSetting('copyright') }}
            </span>

            @if (!empty($links))
                <ul class="mt-4 flex flex-wrap justify-center gap-6 md:mt-0">
                    @foreach ($links as $link)
                        <li>
                            <a class="text-sm font-medium text-neutral-500 transition hover:text-sky-600"
                               href="{{ route($link['route']) }}" wire:navigate>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="flex space-x-4">
                @foreach ($socials as $social)
                    <a class="flex h-10 w-10 items-center justify-center rounded-full bg-neutral-100 text-neutral-500 transition hover:bg-sky-50 hover:text-sky-600"
                       href="{{ $social['url'] }}" target="_blank" rel="noopener">
                        <span class="sr-only">{{ $social['label'] ?? 'Social link' }}</span>
                        @if (isset($social['icon_svg']))
                            {!! $social['icon_svg'] !!}
                        @else
                            <i class="{{ $social['icon'] }} text-xl"></i>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
