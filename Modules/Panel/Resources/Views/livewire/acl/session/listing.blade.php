<div class="flex flex-col">
    <div>
        <div
             class="mb-4 grid gap-3 border-b border-gray-200 pb-4 dark:border-neutral-700 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Sessions
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage sessions, edit and more.
                </p>
            </div>
        </div>

        <div class="card px-4 py-10">
            <div class="m-auto max-w-xl">
                @can('view-session')
                    @if ($data->isNotEmpty())
                        <x-panel::ui.timeline>
                            @foreach ($data as $row)
                                <x-panel::ui.timeline.item>
                                    <div class="timeline-period">
                                        <span>{{ $row->getLastActivity() }}</span>
                                    </div>
                                    <h3 class="timeline-title"> {{ $row->getUserName() }} </h3>
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        {!! $row->sessionInfoBadges() !!}
                                    </div>
                                </x-panel::ui.timeline.item>
                            @endforeach
                        </x-panel::ui.timeline>
                    @else
                        <x-panel::ui.table.empty title="There is no data yet." icon="bx-user"
                                                 description="No sessions have been created yet. Start by adding a new session to manage access control."
                                                 data="Session" />
                    @endif
                @else
                    <div class="py-8 text-center text-red-500">
                        You do not have permission to view sessions.
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
