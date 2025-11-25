<div class="space-y-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="block text-3xl font-extrabold text-primary-600 dark:text-primary-400">
            👋 {{ __('panel::auth.customer_register_heading') }}
        </h1>
        <p class="mt-2 text-base leading-6 text-gray-600 dark:text-zinc-400">
            {{ __('panel::auth.register_subtitle') }}
        </p>
    </div>

    <form class="grid gap-y-4" wire:submit.prevent="register">
        <x-panel::ui.forms.input type="text" label="{{ __('panel::auth.register_name_label') }}" wire:model.defer="name"
                                 required autofocus autocomplete="name"
                                 placeholder="{{ __('panel::auth.register_name_placeholder') }}" />

        <x-panel::ui.forms.input type="email" label="{{ __('panel::auth.register_email_label') }}"
                                 wire:model.defer="email" required autocomplete="email"
                                 placeholder="{{ __('panel::auth.register_email_placeholder') }}" />

        <div class="space-y-2 input-group" x-data="{ showPassword: false }">
            <div class="flex justify-between items-center">
                <label class="form-label" for="password">{{ __('panel::auth.register_password_label') }}</label>
            </div>
            <div class="relative">
                <input class="input-field has-icon-right peer" id="password" :type="showPassword ? 'text' : 'password'"
                       wire:model.defer="password" placeholder="{{ __('panel::auth.register_password_placeholder') }}"
                       required autocomplete="new-password" />
                <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                        type="button" x-on:click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                </button>
            </div>
        </div>

        <x-panel::ui.forms.input type="password" label="{{ __('panel::auth.register_password_confirmation_label') }}"
                                 wire:model.defer="password_confirmation" required autocomplete="new-password"
                                 placeholder="{{ __('panel::auth.register_password_confirmation_placeholder') }}" />

        <x-panel::ui.buttons.submit class="w-full" variant="solid-primary" wire:target="register">
            {{ __('panel::auth.register_button') }}
        </x-panel::ui.buttons.submit>

        @if (Route::has('auth.customer.login'))
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-zinc-400">
                {{ __('panel::auth.register_already_account') }}
                <x-panel::ui.buttons.link href="{{ route('auth.customer.login') }}" wire:navigate>
                    {{ __('panel::auth.register_login_link') }}
                </x-panel::ui.buttons.link>
            </p>
        @endif
    </form>

    {{-- Divider --}}
    <div class="relative">
        <div class="flex absolute inset-0 items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="flex relative justify-center text-sm">
            <span class="px-2 text-gray-500 bg-white">{{ __('panel::auth.or_with') }}</span>
        </div>
    </div>

    {{-- Social Buttons --}}
    <div class="grid grid-cols-2 gap-3">
        <a class="flex gap-2 justify-center items-center w-full btn soft-secondary" href="#">
            <i class="text-xl bxl bx-google"></i> Google
        </a>
        <a class="flex gap-2 justify-center items-center w-full btn soft-secondary" href="#">
            <i class="text-xl bxl bx-facebook"></i> Facebook
        </a>
    </div>

    <div class="text-center">
        <span class="inline-flex gap-1 items-center text-sm text-primary-500 dark:text-primary-300">
            <i class="bx bx-help-circle"></i>
            {{ __('panel::auth.need_help') }}
            <x-panel::ui.buttons.link href="mailto:{{ getSetting('contact_support_email') }}">
                {{ __('panel::auth.contact_support') }}
            </x-panel::ui.buttons.link>
        </span>
    </div>
</div>
