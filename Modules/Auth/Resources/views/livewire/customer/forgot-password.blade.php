<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('panel::auth.customer_forgot_password_heading', [], app()->getLocale()) }}
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            {{ __('panel::auth.customer_forgot_password_subtitle', [], app()->getLocale()) }}
        </p>
    </div>

    <form class="flex flex-col gap-6" wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <x-panel::ui.forms.input type="email" wire:model.defer="email"
                                 label="{{ __('panel::auth.customer_email_label', [], app()->getLocale()) }}" autofocus
                                 placeholder="{{ __('panel::auth.customer_email_placeholder', [], app()->getLocale()) }}" />

        <x-panel::ui.buttons.submit class="w-full" type="submit" variant="solid-primary"
                                    wire:target="sendPasswordResetLink">
            {{ __('panel::auth.customer_email_password_reset_link', [], app()->getLocale()) }}
        </x-panel::ui.buttons.submit>
    </form>

    <div class="space-x-1 text-sm text-center text-zinc-400 rtl:space-x-reverse">
        {{ __('panel::auth.customer_forgot_password_return', [], app()->getLocale()) }}
        <x-panel::ui.buttons.link href="{{ route('auth.customer.login') }}" variant="link-primary" wire:navigate>
            {{ __('panel::auth.customer_login_link', [], app()->getLocale()) }}
        </x-panel::ui.buttons.link>
    </div>
</div>
