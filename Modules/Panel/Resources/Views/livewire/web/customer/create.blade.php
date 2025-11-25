<div>
    <form wire:submit.prevent="handleSubmit">
        <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">

            {{-- CUSTOMER SECTION --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Customer</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Basic identity information.
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6" wire:loading.class="skeleton"
                          wire:target="updateCustomer">
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.name" type="text" label="Name"
                                                 wire:model.defer="form.name" />
                    </div>

                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.email" type="email" label="Email"
                                                 wire:model.defer="form.email" />
                    </div>

                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.switch id="form.email_verified" label="Email Verified"
                                                  wire:model.lazy="form.email_verified" />
                    </div>
                </fieldset>
            </div>

            {{-- SECURITY SECTION --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Security</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Set or update the customer's password.
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6" wire:loading.class="skeleton"
                          wire:target="updatePassword">
                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.password" type="password" label="Password"
                                                 wire:model.defer="form.password" />
                    </div>

                    <div class="sm:col-span-6">
                        <x-panel::ui.forms.input id="form.password_confirmation" type="password"
                                                 label="Confirm Password"
                                                 wire:model.defer="form.password_confirmation" />
                    </div>
                </fieldset>
            </div>

            {{-- ACCESS SECTION --}}
            <div class="col-span-12 md:col-span-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">Access</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage roles and permissions.
                </p>
            </div>

            <div class="col-span-12 md:col-span-8">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6" wire:loading.class="skeleton"
                          wire:target="updateRoles">
                    <div class="col-span-12">
                        <label class="form-label mb-2">Roles</label>
                        <x-panel::utils.tagify-tag :whitelist="$roles" wire:model="form.roles"
                                                   placeholder="Add roles to customer..." />
                    </div>

                    <div class="flex justify-end space-x-2 pt-4 sm:col-span-12">
                        <x-panel::ui.buttons.submit wire:target="handleSubmit">
                            <i class="bx bx-save" wire:loading.remove wire:target="handleSubmit"></i>
                            Save Customer
                        </x-panel::ui.buttons.submit>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>

</div>
