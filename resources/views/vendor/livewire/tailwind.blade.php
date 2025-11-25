<div>
    @if ($paginator->hasPages())
        <nav class="pagination" aria-label="Pagination">

            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-item disabled" aria-disabled="true" aria-label="First">
                    <i class="bx bx-chevrons-left pagination-icon" aria-hidden="true"></i>
                </span>
            @else
                <button class="pagination-item" type="button" aria-label="First"
                        wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')"
                        x-on:click="$store.ui.scrollUp($el)">
                    <i class="bx bx-chevrons-left pagination-icon" aria-hidden="true"></i>
                </button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-item disabled" aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-item active" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <button class="pagination-item" type="button"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    x-on:click="$store.ui.scrollUp($el)">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <button class="pagination-item" type="button" aria-label="Last"
                        wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')"
                        x-on:click="$store.ui.scrollUp($el)">
                    <i class="bx bx-chevrons-right pagination-icon" aria-hidden="true"></i>
                </button>
            @else
                <span class="pagination-item disabled" aria-disabled="true" aria-label="Last">
                    <i class="bx bx-chevrons-right pagination-icon" aria-hidden="true"></i>
                </span>
            @endif

        </nav>
    @endif
</div>
