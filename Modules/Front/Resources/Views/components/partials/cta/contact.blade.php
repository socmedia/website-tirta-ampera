<section class="py-10 sm:py-16 lg:py-24">
    <div
         class="rounded-2xl bg-sky-600 p-6 text-center text-white shadow-xl sm:p-10 md:rounded-3xl md:p-16 md:shadow-2xl">
        <h2 class="mb-2 text-2xl font-extrabold sm:mb-3 sm:text-3xl md:text-4xl">
            {{ getContent('global.cta.contact.title') }}
        </h2>
        <p class="mx-auto mb-6 max-w-md text-base text-sky-100 sm:mb-8 sm:max-w-2xl sm:text-lg md:max-w-3xl">
            {{ getContent('global.cta.contact.subtitle') }}
        </p>
        <a class="btn solid-white btn-lg rounded-full" href="{{ route('front.contact') }}" wire:navigate>
            {{ getContent('global.cta.contact.button.text') }}
            <i class="bx bx-arrow-right-stroke sm:text-xl"></i>
        </a>
    </div>
</section>
