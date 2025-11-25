<div
     class="shadow-2xs flex flex-col rounded-xl border border-gray-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
    <x-panel::ui.widget.card label="Visitors" tooltip="Total number of visitors in the selected period" :stat="numberShortner($visitorCount)"
                             statIcon="bx-user" />
</div>
