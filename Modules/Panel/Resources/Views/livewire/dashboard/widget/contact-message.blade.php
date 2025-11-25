<div
     class="shadow-2xs flex flex-col rounded-xl border border-gray-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
    <x-panel::ui.widget.card label="Contact Messages" tooltip="Number of contact messages not yet seen" :stat="numberShortner($unseenCount)"
                             statIcon="bx-envelope-open" />
</div>
