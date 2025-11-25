<div>
    <div class="grid max-w-screen-lg grid-cols-12 gap-4 md:gap-8">
        <div class="col-span-12 md:col-span-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                Role
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Update and manage user roles and their associated permissions.
            </p>
        </div>

        <div class="col-span-12 md:col-span-8">
            <form wire:submit.prevent="handleSubmit">
                <fieldset class="grid gap-2 sm:grid-cols-12 sm:gap-6" wire:loading.class="skeleton"
                          wire:target="handleSubmit">
                    <div class="sm:col-span-8">
                        <x-panel::ui.forms.input id="form.name" type="text" label="Role Name"
                                                 wire:model.defer="form.name" />
                    </div>

                    <div class="sm:col-span-4">
                        <x-panel::ui.forms.select label="Guard" wire:model.lazy="form.guard_name">
                            <option value="">Choose Guards</option>
                            @foreach ($guards as $item)
                                <option value="{{ $item->value }}">{{ $item->capitalized() }}</option>
                            @endforeach
                        </x-panel::ui.forms.select>
                    </div>

                    {{-- <div class="col-span-12">
                        <label class="mb-2 form-label">Permissions</label>
                        <div x-data="{
                            chosenPermissions: @entangle('form.permissions'),
                            toggleGroup(group, isChecked) {
                                this.chosenPermissions[group].checked = isChecked;
                                Object.keys(this.chosenPermissions[group].data).forEach((key) => {
                                    this.chosenPermissions[group].data[key] = isChecked;
                                });
                            },
                            togglePermission(group, index, isChecked) {
                                this.chosenPermissions[group].data[index] = isChecked;
                                this.chosenPermissions[group].checked = Object.values(this.chosenPermissions[group].data).every(
                                    value => value
                                );
                            },
                        }">
                            <template x-if="!$wire.form.guard_name">
                                <div class="text-sm alert soft-warning">
                                    <span class="self-center"><i class="bx bx-info-circle"></i></span> Please select a
                                    guard first to view available permissions.
                                </div>
                            </template>
                            <template x-if="$wire.form.guard_name">
                                <template x-for="(permissions, group) in chosenPermissions" :key="group">
                                    <div class="py-4">
                                        <label
                                               class="flex gap-2 items-center text-sm font-semibold capitalize text-dark">
                                            <input class="form-checkbox" type="checkbox" :checked="permissions.checked"
                                                   x-on:change="toggleGroup(group, $event.target.checked)">
                                            <span
                                                  x-text="`${group} (${Object.values(permissions.data).filter(Boolean).length}/${Object.keys(permissions.data).length})`"></span>
                                        </label>
                                        <hr class="mt-2 mb-3 border-t border-t-gray-200 dark:border-t-zinc-700">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="(isChecked, index) in permissions.data"
                                                      :key="index">
                                                <label
                                                       class="flex gap-2 items-center text-sm capitalize text-zinc-700 dark:text-zinc-400">
                                                    <input class="form-checkbox" type="checkbox" :checked="isChecked"
                                                           x-on:change="togglePermission(group, index, $event.target.checked)">
                                                    <span x-text="index.split('+')[0]"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div> --}}
                    <div class="col-span-12">
                        <label class="form-label mb-2">Permissions</label>
                        <div x-data="{
                            chosenPermissions: @entangle('form.permissions'),
                            toggleGroup(group, isChecked) {
                                this.chosenPermissions[group].checked = isChecked;
                                Object.keys(this.chosenPermissions[group].data).forEach((key) => {
                                    this.chosenPermissions[group].data[key] = isChecked;
                                });
                            },
                            togglePermission(group, index, isChecked) {
                                this.chosenPermissions[group].data[index] = isChecked;
                                this.chosenPermissions[group].checked = Object.values(this.chosenPermissions[group].data).every(
                                    value => value
                                );
                            },
                        }">
                            <template x-if="!$wire.form.guard_name">
                                <div class="alert soft-warning text-sm">
                                    <span class="self-center"><i class="bx bx-info-circle"></i></span> Please select a
                                    guard first to view available permissions.
                                </div>
                            </template>
                            <template x-if="Object.keys(chosenPermissions).length > 0">
                                <div class="grid md:grid-cols-2">
                                    <template x-for="(permissions, group) in chosenPermissions" :key="group">
                                        <div class="py-4">
                                            <label
                                                   class="flex items-center gap-2 text-sm font-semibold capitalize text-dark">
                                                <input class="form-checkbox" type="checkbox"
                                                       :checked="permissions.checked"
                                                       x-on:change="toggleGroup(group, $event.target.checked)">
                                                <span
                                                      x-text="`${group.replace('-', ' ')} (${Object.values(permissions.data).filter(Boolean).length}/${Object.keys(permissions.data).length})`"></span>
                                            </label>
                                            <hr class="mb-3 mt-2 border-t border-t-gray-200 dark:border-t-zinc-700">
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="(isChecked, index) in permissions.data"
                                                          :key="index">
                                                    <label
                                                           class="flex items-center gap-2 text-sm capitalize text-zinc-700 dark:text-zinc-400">
                                                        <input class="form-checkbox" type="checkbox"
                                                               :checked="isChecked"
                                                               x-on:change="togglePermission(group, index, $event.target.checked)">
                                                        <span x-text="index.split('-')[0]"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4 sm:col-span-12">
                        <x-panel::ui.buttons.submit type="submit" wire:target="handleSubmit">
                            <i class="bx bx-save" wire:loading.class="hidden" wire:target="handleSubmit"></i>
                            Update
                        </x-panel::ui.buttons.submit>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
