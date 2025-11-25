<!-- Cropper Component -->
<div x-data="imageCropper({ imageSrc: null, ratio: 1, showModal: false, onCropped: null })" x-init="initWatchers()">
    <template x-if="showModal">
        <div class="mx-auto w-full max-w-2xl rounded bg-white p-4 shadow dark:bg-neutral-900">
            <div class="mb-4">
                <img class="mx-auto max-h-96" alt="Crop Image" x-ref="image" :src="imageSrc" />
            </div>
            <div class="text-right">
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" x-on:click="applyCrop">
                    Apply
                </button>
            </div>
        </div>
    </template>
</div>

@push('script')
    <script>
        function imageCropper({
            imageSrc,
            ratio,
            showModal,
            onCropped
        }) {
            return {
                imageSrc,
                ratio,
                showModal,
                cropper: null,
                onCropped,

                initWatchers() {
                    this.$watch("imageSrc", (value) => {
                        if (value && this.showModal) {
                            this.initCropper();
                        }
                    });

                    this.$watch("showModal", (value) => {
                        if (value && this.imageSrc) {
                            this.initCropper();
                        } else {
                            this.destroyCropper();
                        }
                    });
                },

                initCropper() {
                    this.$nextTick(() => {
                        if (this.cropper) this.cropper.destroy();

                        const image = this.$refs.image;
                        this.cropper = new Cropper(image, {
                            aspectRatio: this.ratio,
                            viewMode: 1,
                        });
                    });
                },

                destroyCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                },

                applyCrop() {
                    if (!this.cropper) return;

                    const canvas = this.cropper.getCroppedCanvas();
                    if (!canvas) {
                        console.error("Failed to get canvas");
                        return;
                    }

                    canvas.toBlob((blob) => {
                        if (typeof this.onCropped === "function") {
                            this.onCropped(blob);
                        }
                        this.showModal = false;
                    });
                },
            };
        }
    </script>
@endpush
