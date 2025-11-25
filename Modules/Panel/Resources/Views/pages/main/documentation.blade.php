@extends('panel::layouts.master')

@section('title', 'Documentation')

@push('style')
    @vite(['Modules/Panel/Resources/assets/js/markdown.js'])
@endpush

@section('breadcrumb')
    <x-panel::ui.breadcrumb :items="[['label' => 'Home', 'url' => route('panel.web.index')], ['label' => 'Documentation']]" />
@endsection

@section('content')
    <section class="mb-10">
        <div class="max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span
                      class="inline-flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 size-10">
                    <i class="bx bx-book-open text-2xl"></i>
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-neutral-100">
                    Documentation
                </h2>
            </div>
            <p class="text-lg text-gray-700 dark:text-neutral-300 mb-2">
                Discover guides, references, and best practices for all features and modules.
            </p>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                <i class="bx bx-info-circle"></i>
                <span>
                    Use the tabs to browse categories. Select a file or topic from the sidebar to view its content. For more
                    help, visit the support section or contact your administrator.
                </span>
            </div>
        </div>
    </section>

    <div
         class="rounded-xl bg-white/70 dark:bg-zinc-900/70 shadow-sm ring-1 ring-zinc-100 dark:ring-zinc-800 py-10 px-4 md:px-8">
        <livewire:panel::main.documentation.listing :type="$type" :file-name="$filename" :file-path="$filepath" />
    </div>
@endsection

@push('script')
@endpush
