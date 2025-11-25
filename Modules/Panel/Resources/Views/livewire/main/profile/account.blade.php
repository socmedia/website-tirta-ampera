<div class="max-w-screen-md">
    <form wire:submit.prevent="handleUpdateAccount">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Account</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    This is how others will see you on the site.
                </p>
            </div>

            <div class="grid gap-6 lg:col-span-7">
                <div class="flex items-center gap-5">
                    <div class="space-y-4" x-data="avatarCropper()" x-init="init()">
                        <div class="flex items-center gap-4">
                            <!-- Avatar Preview -->
                            <div
                                 class="size-20 overflow-hidden rounded-full border border-2 border-zinc-200 dark:border-zinc-700">
                                <img class="h-full w-full object-cover"
                                     :src="croppedUrl || '{{ url($form['old_avatar']) }}'" />
                            </div>

                            <button class="btn solid-white btn-sm" type="button"
                                    x-on:click="document.querySelector('#avatar-input').click()">
                                Change avatar
                            </button>
                            <!-- File input -->
                            <input class="hidden opacity-0" id="avatar-input" type="file" accept="image/*"
                                   x-on:change="loadFile($event)">
                        </div>

                        <x-panel::ui.modal title="Crop Avatar" variant="modal-sm">
                            <div class="px-4 pt-4">
                                <div class="relative m-auto size-72">
                                    <img class="max-h-full max-w-full" x-ref="image" />
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end gap-2 px-4 pb-4 pt-2">
                                <button class="btn ghost-white btn-sm" type="button"
                                        x-on:click="cancel()">Cancel</button>
                                <button class="btn solid-secondary btn-sm" type="button"
                                        x-on:click="crop()">Crop</button>
                            </div>
                        </x-panel::ui.modal>

                        @if (session()->has('message'))
                            <div class="text-sm text-green-600">{{ session('message') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Name</label>
                    <p class="mb-2 text-xs text-gray-500 dark:text-neutral-400">This is your full name or public alias.
                    </p>
                    <input class="form-input" type="text" wire:model="form.name" placeholder="John Doe" />
                    @error('form.name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                    <p class="mb-2 text-xs text-gray-500 dark:text-neutral-400">We'll send account-related emails here.
                    </p>
                    <input class="form-input" type="email" wire:model="form.email" placeholder="your@email.com" />
                    @error('form.email')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-dark" wire:target="handleUpdateAccount">
                        Update Account
                    </x-panel::ui.buttons.spinner>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Account Section -->
    <div class="mt-10 border-t border-gray-200 pt-10 dark:border-gray-700" x-data="{ show: false }">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-lg font-semibold text-red-600 dark:text-red-400">Delete Account</h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Permanently delete your account and all associated data.
                </p>
            </div>

            <div class="lg:col-span-7">
                <div class="flex justify-end">
                    <x-panel::ui.buttons type="button" variant="solid-danger" x-on:click="show = !show">
                        Delete Account
                    </x-panel::ui.buttons>
                </div>
            </div>
        </div>

        <x-panel::ui.modal title="Delete Account">
            <form class="space-y-6 p-6" wire:submit="handleDeleteAccount">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Are you sure you want to delete your
                        account?</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                        This will permanently delete your account and all associated data. Confirm by entering your
                        password.
                    </p>
                </div>

                <x-panel::ui.forms.input type="password" label="Current Password" wire:model.defer="current_password" />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <x-panel::ui.buttons type="button" variant="ghost-white"
                                         x-on:click="show = false; $wire.set('current_password', null)">
                        Cancel
                    </x-panel::ui.buttons>
                    <x-panel::ui.buttons.spinner type="submit" variant="solid-danger"
                                                 wire:target="handleDeleteAccount">
                        Delete Account
                    </x-panel::ui.buttons.spinner>
                </div>
            </form>
        </x-panel::ui.modal>
    </div>
</div>

@push('script')
    <script>
        function avatarCropper() {
            return {
                show: false,
                cropper: null,
                croppedUrl: null,

                init() {
                    Livewire.on('avatarUpdated', () => {
                        this.croppedUrl = null;
                    });
                },

                loadFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.show = true;
                        this.$nextTick(() => {
                            const image = this.$refs.image;
                            image.src = e.target.result;

                            if (this.cropper) this.cropper.destroy();

                            this.cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                cancel() {
                    this.show = false;
                    if (this.cropper) this.cropper.destroy();
                },

                crop() {
                    if (!this.cropper) return;

                    const canvas = this.cropper.getCroppedCanvas({
                        width: 300,
                        height: 300,
                    });

                    this.croppedUrl = canvas.toDataURL('image/png');
                    @this.set('form.avatar', this.croppedUrl);

                    this.show = false;
                    this.cropper.destroy();
                }
            };
        }
    </script>
@endpush
