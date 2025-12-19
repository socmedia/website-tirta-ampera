@props([
    'title' => null,
    'subtitle' => null,
    'content' => null,
])

<div {{ $attributes->merge(['class' => 'mx-auto mb-10 max-w-2xl text-center sm:max-w-3xl lg:max-w-4xl']) }}>
    <h2 class="mx-auto mt-2 text-3xl font-extrabold leading-tight text-neutral-900 sm:text-4xl md:text-5xl">
        {!! $title !!}
    </h2>
    @if ($subtitle)
        <p class="mx-auto mt-3 text-lg font-medium text-sky-600 sm:text-xl">
            {{ $subtitle }}
        </p>
    @endif
    <p class="mx-auto mt-4 text-base text-neutral-600 sm:text-lg">
        {{ $content }}
    </p>
</div>
