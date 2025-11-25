@extends('panel::layouts.master')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('content')
    <flux:heading size="xl">Settings</flux:heading>

    <flux:separator class="my-8" variant="subtle" />

    <div class="flex flex-col gap-4 lg:flex-row lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">Profile</flux:heading>
            <flux:subheading>This is how others will see you on the site.</flux:subheading>
        </div>

        <div class="flex-1 space-y-6">
            <flux:input label="Username"
                        description="This is your public display name. It can be your real name or a pseudonym. You can only change this once every 30 days."
                        placeholder="calebporzio" />

            <flux:select label="Primary email"
                         description:trailing="You can manage verified email addresses in your email settings."
                         placeholder="Select primary email...">
                <flux:select.option>lotrrules22@aol.com</flux:select.option>
                <flux:select.option>phantomatrix@hotmail.com</flux:select.option>
            </flux:select>

            <flux:textarea label="Bio"
                           description:trailing="You can @mention other users and organizations to link to them."
                           placeholder="Tell us a little bit about yourself" />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Save profile</flux:button>
            </div>
        </div>
    </div>

    <flux:separator class="my-8" variant="subtle" />

    <div class="flex flex-col gap-4 lg:flex-row lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">Preferences</flux:heading>
            <flux:subheading>Customize your layout and notification preferences.</flux:subheading>
        </div>

        <div class="flex-1 space-y-6">
            <flux:checkbox.group label="Sidebar" description="Select the items you want to display in the sidebar.">
                <flux:checkbox value="recents" label="Recents" checked />
                <flux:checkbox value="home" label="Home" checked />
                <flux:checkbox value="applications" label="Applications" />
                <flux:checkbox value="desktop" label="Desktop" />
            </flux:checkbox.group>

            <flux:separator class="my-8" variant="subtle" />

            <flux:radio.group label="Notify me about...">
                <flux:radio value="all" label="All new messages" checked />
                <flux:radio value="direct" label="Direct messages and mentions" />
                <flux:radio value="none" label="Nothing" />
            </flux:radio.group>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Save preferences</flux:button>
            </div>
        </div>
    </div>

    <flux:separator class="my-8" variant="subtle" />

    <div class="flex flex-col gap-4 pb-10 lg:flex-row lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">Email notifications</flux:heading>
            <flux:subheading>Choose which emails you'd like to get from us.</flux:subheading>
        </div>

        <div class="flex-1 space-y-6">
            <flux:fieldset class="space-y-4">
                <flux:switch checked label="Communication emails"
                             description="Receive emails about your account activity." />

                <flux:separator variant="subtle" />

                <flux:switch checked label="Marketing emails"
                             description="Receive emails about new products, features, and more." />

                <flux:separator variant="subtle" />

                <flux:switch label="Social emails" description="Receive emails for friend requests, follows, and more." />

                <flux:separator variant="subtle" />

                <flux:switch label="Security emails"
                             description="Receive emails about your account activity and security." />
            </flux:fieldset>
        </div>
    </div>

    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam excepturi perspiciatis sint molestias expedita
        asperiores
        dolore, corrupti assumenda inventore iusto aspernatur tempore, ab ut libero incidunt accusantium minus distinctio
        quibusdam!
    </p>

    {{--
<livewire:panel::panel.dashboard /> --}}
    {{--
<div class="grid gap-6 2xl:grid-cols-4 md:grid-cols-2">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h4 class="card-title">Project Overview</h4>
                    <div>
                        <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown"
                            data-fc-placement="left-start" type="button">
                            <i class="text-xl mgc_more_2_fill"></i>
                        </button>

                        <div
                            class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                href="javascript:void(0)">
                                Today
                            </a>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                href="javascript:void(0)">
                                Yesterday
                            </a>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="javascript:void(0)">
                                Last Week
                            </a>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="javascript:void(0)">
                                Last Month
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid items-center gap-4 md:grid-cols-2">
                    <div class="order-2 md:order-1">
                        <div class="flex flex-col gap-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i
                                        class="flex items-center justify-center w-10 h-10 text-lg rounded-full mgc_round_fill bg-primary/25 text-primary"></i>
                                </div>
                                <div class="flex-grow ml-3">
                                    <h5 class="mb-1 fw-semibold">Product Design</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Projects</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 bg-gray-400 rounded"></div>
                                        </li>
                                        <li class="list-inline-item"><b>4</b> Employees</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i
                                        class="flex items-center justify-center w-10 h-10 text-lg rounded-full mgc_round_fill bg-danger/25 text-danger"></i>
                                </div>
                                <div class="flex-grow ml-3">
                                    <h5 class="mb-1 fw-semibold">Web Development</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>30</b> Total Projects</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 bg-gray-400 rounded"></div>
                                        </li>
                                        <li class="list-inline-item"><b>5</b> Employees</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i
                                        class="flex items-center justify-center w-10 h-10 text-lg rounded-full mgc_round_fill bg-success/25 text-success"></i>
                                </div>
                                <div class="flex-grow ml-3">
                                    <h5 class="mb-1 fw-semibold">Illustration Design</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>12</b> Total Projects</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 bg-gray-400 rounded"></div>
                                        </li>
                                        <li class="list-inline-item"><b>3</b> Employees</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i
                                        class="flex items-center justify-center w-10 h-10 text-lg rounded-full mgc_round_fill bg-warning/25 text-warning"></i>
                                </div>
                                <div class="flex-grow ml-3">
                                    <h5 class="mb-1 fw-semibold">UI/UX Design</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>8</b> Total Projects</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 bg-gray-400 rounded"></div>
                                        </li>
                                        <li class="list-inline-item"><b>4</b> Employees</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 md:order-2">
                        <div id="project-overview-chart" class="apex-charts"
                            data-colors="#3073F1,#ff679b,#0acf97,#ffbc00"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h4 class="card-title">Daily Task</h4>
                    <div>
                        <select class="form-input form-select-sm">
                            <option selected>Today</option>
                            <option value="1">Yesterday</option>
                            <option value="2">Tomorrow</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-4">
                        <div class="p-2 border border-gray-200 rounded dark:border-gray-700">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Landing
                                    Page Design</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                            </ul>
                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">Create a new landing page
                                (Saas
                                Product)</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><i
                                    class="mr-1 text-xl align-middle mgc_group_line"></i> <b>5</b> People</p>
                        </div>

                        <div class="p-2 border border-gray-200 rounded dark:border-gray-700">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin
                                    Dashboard</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                            </ul>
                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">Create a new Admin dashboard
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><i
                                    class="mr-1 text-xl align-middle mgc_group_line"></i> <b>2</b> People</p>
                        </div>

                        <div class="p-2 border border-gray-200 rounded dark:border-gray-700">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client
                                    Work</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                            </ul>
                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">Create a new Power Project
                                (Sktech
                                design)</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><i
                                    class="mr-1 text-xl align-middle mgc_group_line"></i> <b>2</b> People</p>
                        </div>

                        <div class="p-2 border border-gray-200 rounded dark:border-gray-700">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">UI/UX
                                    Design</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">6 Hrs ago</h5>
                            </ul>
                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">Create a new UI Kit in figma
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><i
                                    class="mr-1 text-xl align-middle mgc_group_line"></i> <b>3</b> People</p>
                        </div>

                        <div class="flex items-center justify-center">
                            <div class="flex animate-spin">
                                <i class="text-xl mgc_loading_2_line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1">
        <div class="card">
            <div class="flex items-center justify-between card-header">
                <h4 class="card-title">Team Customers</h4>
                <div>
                    <select class="form-select form-select-sm">
                        <option selected>Active</option>
                        <option value="1">Offline</option>
                    </select>
                </div>
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-1.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>UI/UX Designer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>2.5 Year Experience</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-2.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Margaret D. Evans</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>PHP Developer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>2 Year Experience</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-3.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Bryan J. Luellen</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Front end Developer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>1 Year Experience</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-4.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Kathryn S. Collier</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>UI/UX Designer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>3 Year Experience</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-5.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Timothy Kauper</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Backend Developer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>2 Year Experience</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <img class="mr-3 rounded-full" src="/images/users/avatar-6.jpg" width="40"
                                alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);"
                                        class="text-gray-600 dark:text-gray-400">Zara Raws</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Python Developer</div>
                                    <i class="mgc_round_fill text-[5px]"></i>
                                    <div>1 Year Experience</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Grid End --> --}}
@endsection

@push('script')
    {{-- --}}
@endpush


{{-- @push('script')
<script src="https://d3js.org/d3-color.v1.min.js"></script>
<script src="https://d3js.org/d3-interpolate.v1.min.js"></script>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script src="{{ asset('assets/dashboard/js/color_generator.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/chart_generator.js') }}"></script>
<script src="{{ asset('vendor/maps/indonesia.min.js') }}"></script>

<script>
    $(function($) {
        /* Economic Potential */
        const economic_potential = null;
        const economic_potential_data = {
            labels: economic_potential.label
            , data: economic_potential.data
        , };

        /* Vulnerable Workers */
        const vulnerable_workers = null;
        const vulnerable_workers_data = {
            labels: vulnerable_workers.label
            , data: vulnerable_workers.data
        , };

        /* Colors */
        const colorScale = d3.interpolateBlues;
        const colorRangeInfo = {
            colorStart: .5
            , colorEnd: 1
            , useEndAsStart: true
        , };

        /* Create Economic Potential Chart */
        const economic_potential_chart = createChart({
            chartId: 'economic-potential-chart'
            , chartData: economic_potential_data
            , colorScale: colorScale
            , colorRangeInfo: colorRangeInfo
        });

        /* Create Vulnerable Workers Chart */
        const vulnerable_workers_chart = createChart({
            chartId: 'vulnerable-workers-chart'
            , chartData: vulnerable_workers_data
            , colorScale: colorScale
            , colorRangeInfo: colorRangeInfo
        });
    });

</script>
@endpush --}}
