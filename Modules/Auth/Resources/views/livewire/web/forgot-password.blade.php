<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
            Forgot password
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-zinc-400">
            Enter your email to receive a password reset link
        </p>
    </div>

    <form class="flex flex-col gap-6" wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <x-panel::ui.forms.input type="email" wire:model.defer="email" label="Email Address" autofocus
                                 placeholder="email@example.com" />

        <x-panel::ui.buttons.submit class="w-full" type="submit" variant="solid-primary"
                                    wire:target="sendPasswordResetLink">
            Email password reset link
        </x-panel::ui.buttons.submit>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400 rtl:space-x-reverse">
        Or, return to
        <x-panel::ui.buttons.link href="{{ route('auth.web.login') }}" variant="link-primary" wire:navigate>
            Log in
        </x-panel::ui.buttons.link>
    </div>
</div>
