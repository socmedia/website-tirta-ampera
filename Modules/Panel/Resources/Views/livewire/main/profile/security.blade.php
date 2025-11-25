<div class="max-w-screen-md">
    <form wire:submit.prevent="handleUpdatePassword">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Security</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Update your password and manage your account security.
                </p>
            </div>

            <div class="grid gap-6 lg:col-span-7">
                <!-- Current Password -->
                <div class="space-y-2 input-group" x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between">
                        <label class="form-label" for="current_password">
                            Current Password
                        </label>
                    </div>

                    <div class="relative">
                        <input class="input-field has-icon-right peer" id="current_password"
                               :type="showPassword ? 'text' : 'password'" wire:model.defer="form.current_password"
                               placeholder="Enter current password" required />

                        <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                                type="button" x-on:click="showPassword = !showPassword">
                            <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                        </button>
                    </div>

                    @error('form.current_password')
                        <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="space-y-2 input-group" x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between">
                        <label class="form-label" for="password">
                            New Password
                        </label>
                    </div>

                    <div class="relative">
                        <input class="input-field has-icon-right peer" id="password"
                               :type="showPassword ? 'text' : 'password'" wire:model.defer="form.password"
                               placeholder="Enter new password" required />

                        <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                                type="button" x-on:click="showPassword = !showPassword">
                            <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                        </button>
                    </div>

                    @error('form.password')
                        <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="space-y-2 input-group" x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between">
                        <label class="form-label" for="password_confirmation">
                            Confirm New Password
                        </label>
                    </div>

                    <div class="relative">
                        <input class="input-field has-icon-right peer" id="password_confirmation"
                               :type="showPassword ? 'text' : 'password'" wire:model.defer="form.password_confirmation"
                               placeholder="Confirm new password" required />

                        <button class="z-50 text-gray-400 input-icon-right hover:text-zinc-900 dark:text-neutral-400 dark:hover:text-white"
                                type="button" x-on:click="showPassword = !showPassword">
                            <i :class="showPassword ? 'bx bx-eye-slash' : 'bx bx-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-dark" wire:target="handleUpdatePassword">
                        Update Password
                    </x-panel::ui.buttons.spinner>
                </div>
            </div>
        </div>
    </form>
</div>
