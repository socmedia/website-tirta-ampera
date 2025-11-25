@props([
    'code' => '404',
    'message' => "Sorry, we couldn't find your page.",
    'title' => 'Oops, something went wrong.',
    'button' => 'Go back',
])

<div class="px-4 py-24 sm:px-6 lg:px-8">
    <div class="max-w-md">
        <h1 class="block text-7xl font-bold text-zinc-800 dark:text-white sm:text-9xl">{{ $code }}</h1>
        <p class="mb-3 mt-3 text-2xl font-semibold text-zinc-700 dark:text-neutral-400">{{ $title }}</p>
        <p class="text-zinc-400 dark:text-neutral-400">{{ $message }}</p>
        <div class="mt-5 flex flex-col items-center gap-2 sm:flex-row sm:gap-3">
            <a class="focus:outline-hidden inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-blue-600 px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 disabled:pointer-events-none disabled:opacity-50 sm:w-auto"
               href="javascript:void(0)" x-on:click="window.history.back()">
                <i class="bx bx-chevron-left text-lg"></i>
                {{ __($button) }}
            </a>
        </div>
    </div>
</div>
