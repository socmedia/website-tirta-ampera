<div class="flex flex-col gap-6">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            Reset password
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            Please enter your new password below.
        </p>
    </div>

    <form class="flex flex-col gap-6" wire:submit="resetPassword">
        <!-- Email Address -->
        <x-panel::ui.forms.input type="email" wire:model.defer="email" label="Email Address" autofocus
                                 placeholder="email@example.com" />

        <!-- Password -->
        <div class="input-group space-y-2" x-data="{ showPassword: false }">
            <div class="flex items-center justify-between">
                <label class="form-label" for="password">
                    Password
                </label>
            </div>

            <div class="relative">
                <input class="input-field has-icon-right peer" id="password" :type="showPassword ? 'text' : 'password'"
                       wire:model.defer="password" placeholder="Password" required />

                <button class="input-icon-right z-50 text-gray-400 hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                        type="button" x-on:click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                </button>
            </div>

            @error('password')
                <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group space-y-2" x-data="{ showPassword: false }">
            <div class="flex items-center justify-between">
                <label class="form-label" for="password_confirmation">
                    Confirm Password
                </label>
            </div>

            <div class="relative">
                <input class="input-field has-icon-right peer" id="password_confirmation"
                       :type="showPassword ? 'text' : 'password'" wire:model.defer="password_confirmation"
                       placeholder="Confirm password" required />

                <button class="input-icon-right z-50 text-gray-400 hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
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
            Reset password
        </x-panel::ui.buttons.submit>
    </form>
</div>
