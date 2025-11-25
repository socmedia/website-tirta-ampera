<div class="max-w-screen-md" x-data="{ dark: $store.ui.dark }">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
        <div class="lg:col-span-5">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Appearance</h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Customize how the application looks and feels.
            </p>
        </div>

        <div class="lg:col-span-7">
            <div class="space-y-4">
                <p class="mb-4 text-xs text-gray-500 dark:text-neutral-400">
                    Choose between light, or dark mode.
                </p>

                <!-- Tabs -->
                <div class="inline-flex space-x-2 rounded-lg bg-gray-100 p-1 dark:bg-neutral-800">
                    <button class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition"
                            type="button" x-on:click="$store.ui.setTheme('light')"
                            :class="!$store.ui.dark ? 'bg-white dark:bg-neutral-700 text-primary-600' :
                                'text-gray-500 dark:text-neutral-400'">
                        <i class="bx bx-sun"></i> Light
                    </button>

                    <button class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition"
                            type="button" x-on:click="$store.ui.setTheme('dark')"
                            :class="$store.ui.dark ? 'bg-white dark:bg-neutral-700 text-primary-600' :
                                'text-gray-500 dark:text-neutral-400'">
                        <i class="bx bx-moon"></i> Dark
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
