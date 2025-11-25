@props(['item' => []])

<div x-data="{ item: @js($item) }" class="timeline-item group dark:bg-neutral-800 dark:border-neutral-600">
    <!-- Icon -->
    <div class="timeline-icon">
        <div class="timeline-icon-content">
            <template x-if="item.icon">
                <div x-html="item.icon"></div>
            </template>
            <template x-if="!item.icon">
                <div class="timeline-icon-dot"></div>
            </template>
        </div>
    </div>
    <!-- End Icon -->

    <!-- Content -->
    <div class="timeline-content">
        @if ($slot)
            {{ $slot }}
        @else
            <template x-if="item.period">
                <div class="timeline-period">
                    <span x-text="item.period"></span>
                </div>
            </template>

            <template x-if="item.title">
                <h3 class="timeline-title" x-text="item.title"></h3>
            </template>

            <template x-if="item.description">
                <div>
                    <p class="timeline-description" x-text="item.description"></p>
                </div>
            </template>
            <template x-if="item.listing && Array.isArray(item.listing)">
                <ul class="timeline-bullets">
                    <template x-for="list in item.listing" :key="list">
                        <li class="timeline-bullet" x-text="list"></li>
                    </template>
                </ul>
            </template>
        @endif
    </div>
</div>
