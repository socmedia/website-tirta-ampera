<div class="block antialiased" x-cloak x-data="dropzone({
    _this: @this,
    uuid: @js($uuid),
    multiple: @js($multiple)
})" x-on:reset-third-party.window="resetThirdParty()">
    <div
         class="flex h-full w-full flex-col items-start justify-center dark:border-neutral-600 dark:hover:border-neutral-500">
        <div class="w-full rounded-lg border border-dashed border-neutral-200">
            <div @dragenter.prevent.document="onDragenter($event)" x-on:click="$refs.input.click()"
                 @dragleave.prevent="onDragleave($event)" @dragover.prevent="onDragover($event)" @drop.prevent="onDrop">
                <div class="flex cursor-pointer flex-col items-center gap-1 bg-white py-12 text-center text-neutral-600 dark:bg-neutral-700"
                     :class="isDragging ? 'bg-neutral-100' : 'bg-white'">
                    <div
                         class="flex size-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-neutral-800">
                        <i class='bx bx-images text-2xl'></i>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 md:text-base">
                        Drop here or <span class="font-semibold text-blue-700 dark:text-white">Browse files</span>
                    </p>

                    @php
                        $hasMaxFileSize = !is_null($this->maxFileSize);
                        $hasMimes = !empty($this->mimes);
                    @endphp
                    <div class="flex justify-center gap-1 text-xs italic text-neutral-400">
                        @if ($hasMaxFileSize)
                            <p>{{ __('Up to :size', ['size' => \Illuminate\Support\Number::fileSize($this->maxFileSize * 1024)]) }}
                            </p>
                        @endif

                        @if ($hasMaxFileSize && $hasMimes)
                            <span class="h-1 w-1 text-neutral-400">·</span>
                        @endif

                        @if ($hasMimes)
                            <p>{{ Str::upper($this->mimes) }}</p>
                        @endif
                    </div>
                    <input class="hidden" type="file" x-ref="input" wire:model="upload"
                           x-on:livewire-upload-start="isLoading = true" x-on:livewire-upload-cancel="isLoading = false"
                           x-on:livewire-upload-finish="isLoading = false; isDropped = false"
                           x-on:livewire-upload-error="isLoading = false; isDropped = false; $wire.set('error', ['Upload error']);"
                           @if (!is_null($this->accept)) accept="{{ $this->accept }}" @endif
                           @if ($multiple === true) multiple @endif>
                </div>
            </div>

            <div class="btn flex items-center justify-center gap-1 border-0 bg-white pb-8" x-show="isLoading">
                <span class="btn-spinner text-neutral-200" role="status" aria-label="loading">
                </span>
                <span class="text-xs">Uploading...</span>
                <button class="btn soft-danger btn-sm size-6 p-0" type="button" x-on:click="cancelUpload">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            @if (!empty($error))
                @foreach ((array) $error as $i => $err)
                    <div class="alert alert-sm soft-danger m-4 flex items-center justify-between"
                         x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2">
                            <i class="bx bx-alert-circle"></i>
                            <span>{{ $err }}</span>
                        </div>
                        <button class="text-neutral-400 hover:text-neutral-700 dark:hover:text-white" type="button"
                                aria-label="Dismiss" x-on:click="show = false">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                @endforeach
            @endif

            @if (isset($files) && count($files) > 0)
                <div
                     class="flex w-full flex-nowrap gap-3 overflow-x-auto border-t border-dashed border-neutral-200 bg-neutral-50 p-4 dark:bg-neutral-800">
                    @foreach ($files as $file)
                        <div
                             class="group relative flex w-[120px] flex-col items-center justify-between rounded-lg p-2 ring-neutral-200 hover:bg-white hover:ring dark:bg-neutral-800 dark:ring-neutral-700">
                            <div class="flex w-full flex-col items-center">
                                @if ($this->isImageMime($file['extension']))
                                    <div class="relative mb-2 aspect-[4/3] w-full flex-none overflow-hidden">
                                        <img class="h-full w-full rounded object-cover"
                                             src="{{ $file['temporaryUrl'] }}" alt="{{ $file['name'] }}">
                                        <div
                                             class="absolute inset-0 rounded bg-black/40 opacity-0 transition group-hover:opacity-100">
                                        </div>
                                        <button class="absolute right-1 top-1 z-10" type="button"
                                                x-on:click="removeUpload('{{ $file['tmpFilename'] }}')">
                                            <i class='bx bx-x text-lg text-white'></i>
                                        </button>
                                    </div>
                                @else
                                    <div
                                         class="relative mb-2 flex h-24 w-24 items-center justify-center rounded bg-neutral-100 dark:bg-neutral-700">
                                        <i class='bx bx-file text-3xl text-neutral-500'></i>
                                        <div
                                             class="absolute inset-0 rounded bg-black/40 opacity-0 transition group-hover:opacity-100">
                                        </div>
                                        <button class="absolute right-1 top-1 z-10" type="button"
                                                x-on:click="removeUpload('{{ $file['tmpFilename'] }}')">
                                            <i class='bx bx-x text-lg text-white'></i>
                                        </button>
                                    </div>
                                @endif
                                <div class="w-full">
                                    <div
                                         class="line-clamp-1 text-center text-xs font-medium text-slate-900 dark:text-slate-100">
                                        {{ $file['name'] }}
                                    </div>
                                    <div class="text-center text-xs text-neutral-500">
                                        {{ \Illuminate\Support\Number::fileSize($file['size']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @script
        <script>
            Alpine.data('dropzone', ({
                _this,
                uuid,
                multiple
            }) => {
                return ({
                    isDragging: false,
                    isDropped: false,
                    isLoading: false,

                    onDrop(e) {
                        this.isDropped = true
                        this.isDragging = false

                        const file = multiple ? e.dataTransfer.files : e.dataTransfer.files[0]

                        const args = ['upload', file, () => {
                            // Upload completed
                            this.isLoading = false
                        }, (error) => {
                            // An error occurred while uploading
                            console.log('livewire-dropzone upload error', error);
                        }, () => {
                            // Uploading is in progress
                            this.isLoading = true
                        }];

                        // Upload file(s)
                        multiple ? _this.uploadMultiple(...args) : _this.upload(...args)
                    },
                    onDragenter() {
                        this.isDragging = true
                    },
                    onDragleave() {
                        this.isDragging = false
                    },
                    onDragover() {
                        this.isDragging = true
                    },
                    cancelUpload() {
                        _this.cancelUpload('upload')

                        this.isLoading = false
                    },
                    removeUpload(tmpFilename) {
                        // Dispatch an event to remove the temporarily uploaded file
                        _this.dispatch(uuid + ':fileRemoved', {
                            tmpFilename
                        })
                    },
                    resetThirdParty() {
                        // Reset dropzone state (clear files, errors, loading, etc.)
                        this.isDragging = false;
                        this.isDropped = false;
                        this.isLoading = false;
                        // Optionally, you may want to clear errors or trigger a Livewire method to reset files
                        // For example, you could call a Livewire method:
                        if (_this && typeof _this.reset === 'function') {
                            _this.reset('upload', 'error');
                        }
                    },
                });
            })
        </script>
    @endscript
</div>
