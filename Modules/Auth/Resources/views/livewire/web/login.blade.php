<div class="space-y-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            Log in
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            Enter your credentials to access your account
        </p>
    </div>

    <form class="grid gap-y-4" wire:submit.prevent="login">
        <x-panel::ui.forms.input type="email" label="Email address" wire:model.defer="email" required autofocus
                                 autocomplete="email" placeholder="email@example.com" />

        <div class="input-group space-y-2" x-data="{ showPassword: false }">
            <div class="flex items-center justify-between">
                <label class="form-label" for="password">
                    Password
                </label>
                @if (Route::has('auth.web.password.request'))
                    <x-panel::ui.buttons.link class="text-sm" href="{{ route('auth.web.password.request') }}"
                                              wire:navigate>
                        Forgot your password?
                    </x-panel::ui.buttons.link>
                @endif
            </div>

            <div class="relative">
                <input class="input-field has-icon-right peer" id="password" :type="showPassword ? 'text' : 'password'"
                       wire:model.defer="password" placeholder="Password" required />

                <button class="input-icon-right z-50 text-gray-400 hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                        type="button" x-on:click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <x-panel::ui.forms.checkbox wire:model="remember" label="Remember me" />

        <!-- Submit Button -->
        <x-panel::ui.buttons.submit class="w-full" variant="solid-primary" wire:target="login">
            Submit
        </x-panel::ui.buttons.submit>

        @if (Route::has('auth.web.register'))
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-zinc-400">
                Don't have an account yet?
                <x-panel::ui.buttons.link href="{{ route('auth.web.register') }}" wire:navigate>
                    Sign up here
                </x-panel::ui.buttons.link>
            </p>
        @endif
    </form>
</div>
