@props([
    'code' => '404',
    'message' => "Sorry, we couldn't find your page.",
    'title' => 'Oops, something went wrong.',
])

<div class="px-4 pb-8 pt-24 sm:px-6 lg:px-8">
    <h1 class="block bg-transparent text-7xl font-bold text-blue-600 sm:text-9xl">{{ $code }}</h1>
    <p class="mb-3 mt-3 bg-transparent text-2xl font-semibold text-blue-600">{{ $title }}</p>
    <p class="text-neutral-600">{{ $message }}</p>
</div>
