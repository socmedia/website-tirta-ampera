 <div
      class="sticky inset-x-0 top-0 z-20 border-y border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800 dark:bg-zinc-900">
     <div class="flex items-center gap-2 border-b border-zinc-200 px-4 py-2 py-3 dark:border-zinc-700 sm:px-6 lg:px-8">
         <div class="flex-none self-center" :class="$store.ui.sidebarOpen ? 'hidden lg:block' : 'block lg:hidden'">
             <a class="focus:outline-hidden focus:opacity-80 dark:text-white" href="{{ route('panel.web.index') }}"
                aria-label="Brand" wire:navigate>
                 <img class="mx-auto h-8 dark:hidden" src="{{ getsetting('logogram') }}" alt="Logo">
                 <img class="mx-auto hidden h-8 dark:block" src="{{ getsetting('logogram_dark') }}" alt="Logo">
             </a>
         </div>

         <div>
             <button class="focus:outline-hidden relative flex size-8 items-center justify-center rounded-lg border border-zinc-200 text-zinc-800 hover:text-zinc-500 focus:text-zinc-500 disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-zinc-500 dark:focus:text-zinc-500"
                     type="button" x-on:click="$store.ui.toggleSidebar()">
                 <span class="sr-only">Toggle Navigation</span>
                 <i class="bx bx-dock-left-arrow" :class="{ 'bx-dock-right-arrow': $store.ui.sidebarOpen }"></i>
             </button>
         </div>

         <div
              class="input-group hidden max-w-sm space-y-2 focus-within:text-zinc-900 dark:text-zinc-400 dark:focus-within:text-white md:block">
             <div class="relative">
                 <input class="input-field has-icon-right" id="search" type="text"
                        placeholder="Search a menu..." />

                 <span class="input-icon-right z-50 text-zinc-400">
                     <i class="bx bx-search"></i>
                 </span>
             </div>
         </div>

         <div class="ml-auto flex gap-2">
             <livewire:panel::ui.navbar.menu />
             {{-- <livewire:panel::ui.navbar.notification /> --}}
         </div>
     </div>
 </div>
