<div>
    <div class="mt-4 flex flex-col gap-6 md:flex-row">
        <!-- Treeview Sidebar -->
        <div class="mb-4 w-full md:mb-0 md:w-1/4">
            <nav class="sticky top-20">
                <div class="hs-accordion-group flex w-full flex-col flex-wrap px-2 pb-0">
                    <ul>
                        @foreach ($documentationCases as $case)
                            @php
                                $isParentActive = $case->value === $type;
                                $parentUrl = route('panel.main.documentation.show', [
                                    'type' => $case->value,
                                    'filename' => $case->defaultFile(),
                                ]);
                            @endphp
                            <li>
                                <a class="focus:outline-hidden {{ $isParentActive ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-white font-semibold' : '' }} flex flex-1 items-center gap-x-3.5 rounded-lg px-2.5 py-2 text-sm text-zinc-800 hover:bg-zinc-100 focus:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800 dark:focus:bg-zinc-800"
                                   href="{{ $parentUrl }}" wire:navigate>
                                    {{ ucfirst(str_replace('-', ' ', $case->value)) }}
                                </a>
                                @if ($isParentActive && !empty($childFiles))
                                    <ul class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2">
                                        @foreach ($childFiles as $child)
                                            @php
                                                $isActive = $child['name'] === $fileName;
                                                $url = route('panel.main.documentation.show', [
                                                    'type' => $type,
                                                    'filename' => $child['name'],
                                                ]);
                                            @endphp
                                            @hasanyrole($child['roles'])
                                                <li>
                                                    <a class="focus:outline-hidden {{ $isActive ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-white font-semibold' : '' }} block flex items-center gap-x-3.5 rounded-lg px-2.5 py-2 text-xs text-zinc-800 hover:bg-zinc-100 focus:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800 dark:focus:bg-zinc-800"
                                                       href="{{ $url }}" wire:navigate>
                                                        {{ ucfirst(str_replace('-', ' ', $child['name'])) }}
                                                    </a>
                                                </li>
                                            @endhasanyrole
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Documentation Content -->
        <div class="w-full md:w-3/4 md:border-l md:border-gray-200 md:pl-8">
            <div class="prose prose-base max-w-none dark:prose-invert" x-data="markdownComponent" x-init="initContent()">
                <div x-ref="content" x-cloak>
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>
</div>
