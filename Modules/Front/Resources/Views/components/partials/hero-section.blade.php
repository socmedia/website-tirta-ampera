@props([
    'title' => null,
    'subtitle' => null,
    'image' => null,
])


<div class="relative flex min-h-[442px] items-center justify-center overflow-hidden bg-black/70 p-0"
     style="background-image: url('{{ asset($image) }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 to-black/50"></div>

    <div class="relative z-10 flex h-full w-full items-center py-16 sm:py-20 md:py-32">
        <div class="container mx-auto">

            @if ($subtitle)
                <div class="mb-4 flex items-center text-2xl font-medium text-blue-600">
                    <span class="mr-3 inline-block h-0.5 w-6 bg-blue-600"></span> {{ $subtitle }}
                </div>
            @endif

            @if ($title)
                <h1
                    class="font-montserrat max-w-4xl text-xl font-extrabold leading-tight text-white sm:text-3xl md:text-5xl">
                    {{ $title }}
                </h1>
            @endif

        </div>
    </div>
</div>
