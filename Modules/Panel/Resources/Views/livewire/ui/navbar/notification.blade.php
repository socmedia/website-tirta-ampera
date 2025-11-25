<div class="focus:outline-hidden relative flex size-8 items-center justify-center rounded-lg border border-zinc-200 text-zinc-800 hover:text-zinc-500 focus:text-zinc-500 disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-zinc-500 dark:focus:text-zinc-500"
     x-data="{ open: false }">
    <!-- Trigger Button -->
    <button class="group relative flex items-center justify-center" type="button" aria-haspopup="true"
            aria-label="Dropdown" x-on:click="open = !open" @keydown.escape.window="open = false" :aria-expanded="open">
        <i class="bx bx-bell text-lg"></i>
    </button>

    <!-- Menu Dot -->
    <span class="absolute -end-0.5 -top-0.5">
        <span class="relative flex">
            <span
                  class="absolute inline-flex size-full animate-ping rounded-full bg-red-400 opacity-75 dark:bg-red-600"></span>
            <span class="relative inline-flex size-2 rounded-full bg-red-500"></span>
            <span class="sr-only">Menu</span>
        </span>
    </span>

    <!-- Dropdown Menu -->
    <div class="w-xs absolute right-0 top-8 z-30 mt-2 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-700 dark:bg-zinc-800"
         role="menu" aria-orientation="vertical" x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1" x-on:click.outside="open = false" x-cloak>

        <div class="p-4 text-sm text-zinc-700 dark:text-zinc-200">
            <div class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                <h5 class="text-lg font-semibold text-zinc-800 dark:text-white/90">
                    Notification
                </h5>

                <button class="text-zinc-500 dark:text-zinc-400" x-on:click="open = false">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <ul class="flex h-auto max-h-64 flex-col overflow-y-auto">
                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Terry Franci</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>5 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Alena Franci</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>8 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Jocelyn Kenter</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>15 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-error-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Brandon Philips</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>1 hr ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Terry Franci</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>5 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Alena Franci</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>8 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-success-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Jocelyn Kenter</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>15 min ago</span>
                            </span>
                        </span>
                    </a>
                </li>

                <li>
                    <a class="px-4.5 flex gap-3 rounded-lg border-b border-zinc-100 p-3 py-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-white/5"
                       href="#">
                        <span class="z-1 relative block h-10 w-full max-w-10 rounded-full">
                            <img class="overflow-hidden rounded-full" src="" alt="User">
                            <span
                                  class="bg-error-500 absolute bottom-0 right-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-zinc-900"></span>
                        </span>

                        <span class="block">
                            <span class="mb-1.5 block text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="font-medium text-zinc-800 dark:text-white/90">Brandon Philips</span>
                                requests permission to change
                                <span class="font-medium text-zinc-800 dark:text-white/90">Project - Nganter
                                    App</span>
                            </span>

                            <span class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span>Project</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-400"></span>
                                <span>1 hr ago</span>
                            </span>
                        </span>
                    </a>
                </li>
            </ul>

            <a class="shadow-xs mt-3 flex justify-center rounded-lg border border-zinc-300 bg-white p-3 text-sm font-medium text-zinc-700 hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200"
               href="#">
                View All Notification
            </a>
        </div>

    </div>
</div>
