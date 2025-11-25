<div
     class="shadow-2xs flex flex-col rounded-xl border border-gray-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
    <x-panel::ui.widget.card label="Pending Applicants" tooltip="Number of applicants with pending status"
                             :stat="numberShortner($unseenCount)" statIcon="bx-user" />
</div>
