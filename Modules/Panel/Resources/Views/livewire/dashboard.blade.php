<div>
    <div class="w-full space-y-6">
        <div class="mb-4 mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Analytics</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                    Overview of your analytics data
                    @if (!empty($dateRange['start']) && !empty($dateRange['end']))
                        @if ($dateRange['start'] === $dateRange['end'])
                            <span class="font-bold">on</span> {{ carbon($dateRange['start'])->format('d M Y') }}
                        @else
                            <span class="font-bold">from</span> {{ carbon($dateRange['start'])->format('d M Y') }}
                            <span class="font-bold">to</span> {{ carbon($dateRange['end'])->format('d M Y') }}
                        @endif
                    @else
                        <span class="font-bold">from</span> - <span class="font-bold">to</span> -
                    @endif
                </p>
            </div>
            <div class="w-full max-w-sm">
                <x-panel::utils.daterangepicker placeholder="Select date range" model="dateRange" :options="['locale' => ['format' => 'YYYY-MM-DD']]"
                                                :start-date="$dateRange['start']" :end-date="$dateRange['end']" />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
            {{-- <livewire:panel::dashboard.widget.collaboration :dateRange="$dateRange" /> --}}
            <livewire:panel::dashboard.widget.contact-message :dateRange="$dateRange" />
            {{-- <livewire:panel::dashboard.widget.applicant :dateRange="$dateRange" /> --}}
            <livewire:panel::dashboard.widget.visitor :dateRange="$dateRange" />
        </div>

        <div class="grid gap-4 sm:gap-6 lg:grid-cols-3">
            <div
                 class="min-h-102.5 shadow-2xs flex flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800 md:p-5 lg:col-span-2">
                <livewire:panel::dashboard.chart.visitor :dateRange="$dateRange" />
            </div>

            <div
                 class="min-h-102.5 shadow-2xs flex flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800 md:p-5 lg:col-span-1">
                <livewire:panel::dashboard.chart.device :dateRange="$dateRange" />
            </div>
        </div>
    </div>

</div>
