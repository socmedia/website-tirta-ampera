@extends('front::layouts.master')

@section('title', getContent('seo.contact.title'))

@push('meta')
    <x-front::partials.meta :title="getContent('seo.contact.title')" :description="getContent('seo.contact.description')" :keywords="getContent('seo.contact.keywords')" :image="getContent('seo.contact.image')" />
@endpush

@push('style')
    @vite('Modules/Front/Resources/assets/js/libphonenumber.js')
@endpush

@section('content')
    {{-- BREADCRUMB --}}
    <x-front::ui.breadcrumb title="{{ __('front::navbar.contact') }}" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.contact')],
    ]" />

    <div class="relative bg-white py-36">
        <div class="absolute right-[-40px] top-1/3 z-0 h-[220px] w-[220px] rounded-full bg-blue-100 blur-3xl"></div>
        <div class="absolute left-[-60px] top-[180px] z-0 h-[200px] w-[200px] rounded-full bg-blue-200 blur-3xl"></div>
        <div class="absolute bottom-[-100px] left-[40px] z-0 h-[300px] w-[300px] rounded-full bg-blue-50 blur-3xl"></div>

        <div class="container relative z-10">
            <x-front::partials.section-title :title="getContent('contact.inquiry.heading')" :content="getContent('contact.inquiry.description')" />

            <div class="m-auto max-w-screen-lg">
                <div class="grid grid-cols-1 gap-x-10 md:grid-cols-2 lg:gap-x-16">
                    <!-- Form -->
                    <div class="mb-10 border-b border-gray-200 pb-10 md:order-2 md:mb-0 md:border-b-0 md:pb-0">
                        <livewire:front::contact.form />
                    </div>

                    <!-- Info -->
                    <div class="space-y-14">
                        <!-- Address -->
                        <div class="flex gap-x-5">
                            <i class='bx bx-map size-6 shrink-0 text-2xl text-neutral-500'></i>
                            <div>
                                <h4 class="font-semibold text-neutral-500">Our address:</h4>
                                <address class="mt-1 text-sm not-italic text-neutral-400">
                                    {{ getSetting('contact_address') }}
                                </address>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex gap-x-5">
                            <i class='bx bx-envelope size-6 shrink-0 text-2xl text-neutral-500'></i>
                            <div>
                                <h4 class="font-semibold text-neutral-500">Email us:</h4>
                                <a class="mt-1 text-sm text-neutral-400 hover:text-neutral-500"
                                   href="mailto:{{ getSetting('contact_email') }}">{{ getSetting('contact_email') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Info -->
                </div>
                <!-- End Grid -->
            </div>

        </div>
    </div>
@endsection
