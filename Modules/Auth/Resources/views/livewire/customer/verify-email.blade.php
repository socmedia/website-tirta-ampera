<div class="flex flex-col gap-6">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('panel::auth.customer_verify_email_heading') }}
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            {{ __('panel::auth.customer_verify_email_subheading') }}
        </p>
    </div>

    @if ($resent)
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
             role="alert">
            {{ __('panel::auth.customer_verify_email_resent') }}
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <p class="text-sm text-gray-600 dark:text-zinc-400">
            {{ __('panel::auth.customer_verify_email_instruction') }}
        </p>
        <form wire:submit.prevent="resend">
            <x-panel::ui.buttons.submit class="w-full" variant="solid-primary" wire:target="resend">
                {{ __('panel::auth.customer_verify_email_resend_button') }}
            </x-panel::ui.buttons.submit>
        </form>
    </div>
</div>
