@extends('panel::layouts.master')

@section('title', 'Homepage')

@push('style')
    <style>
        html canvas {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <section class="text-gray-600 body-font">
        <div class="container flex flex-col items-center px-5 py-24 mx-auto md:flex-row">
            <div
                 class="flex flex-col items-center mb-16 text-center md:mb-0 md:w-1/2 md:items-start md:pr-16 md:text-left lg:flex-grow lg:pr-24">
                <h1 class="mb-4 text-3xl font-medium text-gray-900 title-font sm:text-4xl">Before they sold out
                    <br class="hidden lg:inline-block">readymade gluten
                </h1>
                <p class="mb-8 leading-relaxed">Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant
                    cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic
                    tumeric truffaut hexagon try-hard chambray.</p>
                <div class="flex justify-center">
                    <button
                            class="inline-flex px-6 py-2 text-lg text-white bg-indigo-500 rounded border-0 hover:bg-indigo-600 focus:outline-none">Button</button>
                    <button
                            class="inline-flex px-6 py-2 ml-4 text-lg text-gray-700 bg-gray-100 rounded border-0 hover:bg-gray-200 focus:outline-none">Button</button>
                </div>
            </div>
            <div class="w-5/6 md:w-1/2 lg:w-full lg:max-w-lg">
                <img class="object-cover object-center rounded" src="https://dummyimage.com/720x600" alt="hero">
            </div>
        </div>
    </section>


    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="mb-20 text-center">
                <h1 class="mb-4 text-2xl font-medium text-gray-900 title-font sm:text-3xl">Explore Our Features</h1>
                <p class="mx-auto text-base leading-relaxed text-gray-500 lg:w-3/4 xl:w-2/4">Discover the unique features we
                    offer to enhance your experience. Navigate through our dashboard, connect with customers, and manage
                    vendors efficiently.</p>
                <div class="flex justify-center mt-6">
                    <div class="inline-flex w-16 h-1 bg-indigo-500 rounded-full"></div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-4 -mt-4 -mb-10 space-y-6 sm:-m-4 md:space-y-0">
                <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                    <div
                         class="inline-flex flex-shrink-0 justify-center items-center mb-5 w-20 h-20 text-indigo-500 bg-indigo-100 rounded-full">
                        <i class='text-3xl bx bx-home-alt'></i>
                    </div>
                    <div class="flex-grow">
                        <h2 class="mb-3 text-lg font-medium text-gray-900 title-font">Dashboard</h2>
                        <p class="text-base leading-relaxed">Access your personalized dashboard to monitor and manage your
                            activities seamlessly.</p>
                        <a class="inline-flex items-center mt-3 text-indigo-500" href="{{ route('') }}">Go to
                            Dashboard
                            <i class='ml-2 w-4 h-4 bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                    <div
                         class="inline-flex flex-shrink-0 justify-center items-center mb-5 w-20 h-20 text-indigo-500 bg-indigo-100 rounded-full">
                        <i class='text-3xl bx bx-user'></i>
                    </div>
                    <div class="flex-grow">
                        <h2 class="mb-3 text-lg font-medium text-gray-900 title-font">Customer</h2>
                        <p class="text-base leading-relaxed">Engage with your customers and manage their profiles and
                            interactions effectively.</p>
                        <a class="inline-flex items-center mt-3 text-indigo-500"
                           href="{{ route('auth.customer.login.form') }}">Manage
                            Customers
                            <i class='ml-2 w-4 h-4 bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col items-center p-4 text-center md:w-1/3">
                    <div
                         class="inline-flex flex-shrink-0 justify-center items-center mb-5 w-20 h-20 text-indigo-500 bg-indigo-100 rounded-full">
                        <i class='text-3xl bx bx-store'></i>
                    </div>
                    <div class="flex-grow">
                        <h2 class="mb-3 text-lg font-medium text-gray-900 title-font">Vendor</h2>
                        <p class="text-base leading-relaxed">Oversee vendor relationships and streamline your supply chain
                            management.</p>
                        <a class="inline-flex items-center mt-3 text-indigo-500"
                           href="{{ route('auth.vendor.login.form') }}">View Vendors
                            <i class='ml-2 w-4 h-4 bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>
            <button
                    class="flex px-8 py-2 mx-auto mt-16 text-lg text-white bg-indigo-500 rounded border-0 hover:bg-indigo-600 focus:outline-none">Explore
                More</button>
        </div>
    </section>

    <section class="relative text-gray-600 body-font">
        <div class="container flex flex-wrap px-5 py-24 mx-auto sm:flex-nowrap">
            <div
                 class="flex overflow-hidden relative justify-start items-end p-10 bg-gray-300 rounded-lg sm:mr-10 md:w-1/2 lg:w-2/3">
                <iframe class="absolute inset-0"
                        src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=%C4%B0zmir+(My%20Business%20Name)&ie=UTF8&t=&z=14&iwloc=B&output=embed"
                        title="map" style="filter: grayscale(1) contrast(1.2) opacity(0.4);" width="100%"
                        height="100%" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
                <div class="flex relative flex-wrap py-6 bg-white rounded shadow-md">
                    <div class="px-6 lg:w-1/2">
                        <h2 class="text-xs font-semibold tracking-widest text-gray-900 title-font">ADDRESS</h2>
                        <p class="mt-1">Photo booth tattooed prism, portland taiyaki hoodie neutra typewriter</p>
                    </div>
                    <div class="px-6 mt-4 lg:mt-0 lg:w-1/2">
                        <h2 class="text-xs font-semibold tracking-widest text-gray-900 title-font">EMAIL</h2>
                        <a class="leading-relaxed text-indigo-500">example@email.com</a>
                        <h2 class="mt-4 text-xs font-semibold tracking-widest text-gray-900 title-font">PHONE</h2>
                        <p class="leading-relaxed">123-456-7890</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mt-8 w-full bg-white md:ml-auto md:mt-0 md:w-1/2 md:py-8 lg:w-1/3">
                <h2 class="mb-1 text-lg font-medium text-gray-900 title-font">Feedback</h2>
                <p class="mb-5 leading-relaxed text-gray-600">Post-ironic portland shabby chic echo park, banjo fashion axe
                </p>
                <div class="relative mb-4">
                    <label class="text-sm leading-7 text-gray-600" for="name">Name</label>
                    <input class="px-3 py-1 w-full text-base leading-8 text-gray-700 bg-white rounded border border-gray-300 transition-colors duration-200 ease-in-out outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                           id="name" name="name" type="text">
                </div>
                <div class="relative mb-4">
                    <label class="text-sm leading-7 text-gray-600" for="email">Email</label>
                    <input class="px-3 py-1 w-full text-base leading-8 text-gray-700 bg-white rounded border border-gray-300 transition-colors duration-200 ease-in-out outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                           id="email" name="email" type="email">
                </div>
                <div class="relative mb-4">
                    <label class="text-sm leading-7 text-gray-600" for="message">Message</label>
                    <textarea class="px-3 py-1 w-full h-32 text-base leading-6 text-gray-700 bg-white rounded border border-gray-300 transition-colors duration-200 ease-in-out outline-none resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                              id="message" name="message"></textarea>
                </div>
                <button
                        class="px-6 py-2 text-lg text-white bg-indigo-500 rounded border-0 hover:bg-indigo-600 focus:outline-none">Button</button>
                <p class="mt-3 text-xs text-gray-500">Chicharrones blog helvetica normcore iceland tousled brook viral
                    artisan.</p>
            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font">
        <div class="container flex flex-col items-center px-5 py-24 mx-auto md:flex-row">
            <div class="flex flex-col pr-0 mb-6 w-full text-center md:mb-0 md:w-auto md:pr-10 md:text-left">
                <h2 class="mb-1 text-xs font-medium tracking-widest text-indigo-500 title-font">ROOF PARTY POLAROID</h2>
                <h1 class="text-2xl font-medium text-gray-900 title-font md:text-3xl">Master Cleanse Reliac Heirloom</h1>
            </div>
            <div class="flex flex-shrink-0 items-center mx-auto space-x-4 md:ml-auto md:mr-0">
                <button
                        class="inline-flex items-center px-5 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                        <path
                              d="M99.617 8.057a50.191 50.191 0 00-38.815-6.713l230.932 230.933 74.846-74.846L99.617 8.057zM32.139 20.116c-6.441 8.563-10.148 19.077-10.148 30.199v411.358c0 11.123 3.708 21.636 10.148 30.199l235.877-235.877L32.139 20.116zM464.261 212.087l-67.266-37.637-81.544 81.544 81.548 81.548 67.273-37.64c16.117-9.03 25.738-25.442 25.738-43.908s-9.621-34.877-25.749-43.907zM291.733 279.711L60.815 510.629c3.786.891 7.639 1.371 11.492 1.371a50.275 50.275 0 0027.31-8.07l266.965-149.372-74.849-74.847z">
                        </path>
                    </svg>
                    <span class="flex flex-col items-start ml-4 leading-none">
                        <span class="mb-1 text-xs text-gray-600">GET IT ON</span>
                        <span class="font-medium title-font">Google Play</span>
                    </span>
                </button>
                <button
                        class="inline-flex items-center px-5 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 305 305">
                        <path
                              d="M40.74 112.12c-25.79 44.74-9.4 112.65 19.12 153.82C74.09 286.52 88.5 305 108.24 305c.37 0 .74 0 1.13-.02 9.27-.37 15.97-3.23 22.45-5.99 7.27-3.1 14.8-6.3 26.6-6.3 11.22 0 18.39 3.1 25.31 6.1 6.83 2.95 13.87 6 24.26 5.81 22.23-.41 35.88-20.35 47.92-37.94a168.18 168.18 0 0021-43l.09-.28a2.5 2.5 0 00-1.33-3.06l-.18-.08c-3.92-1.6-38.26-16.84-38.62-58.36-.34-33.74 25.76-51.6 31-54.84l.24-.15a2.5 2.5 0 00.7-3.51c-18-26.37-45.62-30.34-56.73-30.82a50.04 50.04 0 00-4.95-.24c-13.06 0-25.56 4.93-35.61 8.9-6.94 2.73-12.93 5.09-17.06 5.09-4.64 0-10.67-2.4-17.65-5.16-9.33-3.7-19.9-7.9-31.1-7.9l-.79.01c-26.03.38-50.62 15.27-64.18 38.86z">
                        </path>
                        <path
                              d="M212.1 0c-15.76.64-34.67 10.35-45.97 23.58-9.6 11.13-19 29.68-16.52 48.38a2.5 2.5 0 002.29 2.17c1.06.08 2.15.12 3.23.12 15.41 0 32.04-8.52 43.4-22.25 11.94-14.5 17.99-33.1 16.16-49.77A2.52 2.52 0 00212.1 0z">
                        </path>
                    </svg>
                    <span class="flex flex-col items-start ml-4 leading-none">
                        <span class="mb-1 text-xs text-gray-600">Download on the</span>
                        <span class="font-medium title-font">App Store</span>
                    </span>
                </button>
            </div>
        </div>
    </section>
@endsection

@push('script')
    {{--  --}}
@endpush
