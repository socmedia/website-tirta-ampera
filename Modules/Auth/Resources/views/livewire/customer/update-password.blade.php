<div class="flex flex-col gap-6">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('panel::auth.customer_reset_password_heading') }}
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            {{ __('panel::auth.customer_reset_password_subheading') }}
        </p>
    </div>

    <form class="flex flex-col gap-6" wire:submit="resetPassword">
        <!-- Email Address -->
        <x-panel::ui.forms.input type="email" wire:model.defer="email" :label="__('panel::auth.customer_email_label')" autofocus :placeholder="__('panel::auth.customer_email_placeholder')" />

        <!-- Password -->
        <div class="space-y-2 input-group" x-data="{ showPassword: false }">
            <div class="flex justify-between items-center">
                <label class="form-label" for="password">
                    {{ __('panel::auth.customer_password_label') }}
                </label>
            </div>

            <div class="relative">
                <input class="input-field has-icon-right peer" id="password" :type="showPassword ? 'text' : 'password'"
                       wire:model.defer="password" :placeholder="__('panel::auth.customer_password_placeholder')"
                       required />

                <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                        type="button" x-on:click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                </button>
            </div>

            @error('password')
                <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2 input-group" x-data="{ showPassword: false }">
            <div class="flex justify-between items-center">
                <label class="form-label" for="password_confirmation">
                    {{ __('panel::auth.customer_password_confirmation_label') }}
                </label>
            </div>

            <div class="relative">
                <input class="input-field has-icon-right peer" id="password_confirmation"
                       :type="showPassword ? 'text' : 'password'" wire:model.defer="password_confirmation"
                       :placeholder="__('panel::auth.customer_password_confirmation_placeholder')" required />

                <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                        type="button" x-on:click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                </button>
            </div>
            @error('password_confirmation')
                <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit Button -->
        <x-panel::ui.buttons.submit class="w-full" variant="solid-primary" wire:target="resetPassword">
            {{ __('panel::auth.customer_reset_password_button') }}
        </x-panel::ui.buttons.submit>
    </form>
</div>
