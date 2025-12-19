@extends('front::layouts.master')

@section('title', getContent('seo.pay_bill.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('pay_bill.header.title')" :description="getContent('pay_bill.header.description')" :keywords="getContent('pay_bill.header.keywords')" :image="getContent('pay_bill.header.image')" />
@endpush
@section('content')
    <x-front::ui.breadcrumb title="Bayar Tagihan Online" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.service'), 'url' => route('front.service.index')],
        ['label' => 'Bayar Tagihan Online'],
    ]" />

    <section class="py-32">
        <div class="container">
            <div class="flex w-full flex-col items-center">
                <div class="flex flex-col items-center space-y-4 text-center sm:space-y-6 md:max-w-3xl md:text-center">
                    <p class="badge soft-primary badge-lg rounded-full uppercase">
                        {!! getContent('pay_bill.header.badge') !!}
                    </p>
                    <h2 class="text-3xl font-extrabold text-neutral-900 md:text-5xl">
                        {!! getContent('pay_bill.header.title') !!}
                    </h2>
                    <p class="text-neutral-500 md:max-w-2xl">
                        {!! getContent('pay_bill.header.description') !!}
                    </p>
                </div>
            </div>

            {{-- <div class="mx-auto my-16 max-w-4xl">
                <livewire:front::service.pay-bill />
            </div> --}}


            <div class="mx-auto mt-20 grid max-w-5xl gap-8 md:grid-cols-2">
                @foreach (getContent('pay_bill.cards', 'value') as $card)
                    <div
                         class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                        <div class="flex h-full flex-col rounded-lg bg-white p-6">
                            <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                                <i class="{{ $card['icon'] ?? '' }} text-3xl text-sky-600"></i>
                            </span>
                            <div>
                                <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">
                                    {!! $card['title'] ?? '' !!}
                                </h3>
                                <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                    @foreach ($card['items'] ?? [] as $item)
                                        <li>{!! $item !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-front::partials.cta.apps-secondary />
@endsection
