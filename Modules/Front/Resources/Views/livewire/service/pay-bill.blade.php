<div class="relative">
    <div class="relative z-10 mb-12 overflow-hidden rounded-xl bg-white ring-4 ring-transparent ring-offset-2 ring-offset-white"
         class="pointer-events-none absolute inset-0 z-0"
         style="background:
        linear-gradient(white, white) padding-box,
        linear-gradient(135deg, #f1faff, #bbeaff 40%, #eaf9ff 100%) border-box;
        border-radius: 1rem;
        border: 4px solid transparent;">

        <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 via-white to-sky-100/70"></div>
        <div class="absolute inset-x-0 top-0 z-[1] flex h-full w-full items-center justify-center opacity-100">
            <img class="opacity-90 [mask-image:radial-gradient(75%_75%_at_center,white,transparent)]"
                 src="/assets/images/bg-grid.svg" alt="Grid Background" />
        </div>

        <div class="relative z-20 px-6 py-10 md:px-10 md:py-12">
            <div class="mb-8 max-w-xl">
                <div class="mb-2 text-xl font-bold text-sky-700 md:text-2xl">
                    Bayar Tagihan PDAM Online
                </div>
                <div class="text-base text-neutral-600">
                    Masukkan nomor pelanggan Anda untuk cek dan membayar tagihan air secara mudah dan aman.
                </div>
            </div>

            {{-- FORM LIVEWIRE --}}
            <form class="flex flex-col items-start gap-4 backdrop-blur-sm md:flex-row md:items-end"
                  wire:submit.prevent="checkBill">

                <div class="w-full flex-1">
                    <x-front::ui.forms.input label="Nomor Pelanggan" placeholder="Contoh: 1234567890" maxlength="20"
                                             wire:model.defer="no_sambungan" />
                </div>

                <button class="btn solid-primary flex h-[44px] w-full items-center justify-center gap-2 px-6 py-2.5 text-base font-semibold md:w-auto"
                        type="submit" wire:loading.attr="disabled">
                    <i class="bx bx-search"></i>
                    <span wire:loading.remove wire:target="checkBill">Cek Tagihan</span>
                    <span wire:loading wire:target="checkBill"><i class="bx bx-loader bx-spin"></i>Memproses...</span>
                </button>
            </form>

            {{-- LIVEWIRE RESPONSE --}}
            @if ($billData)
                <div class="mt-10">
                    <div class="rounded-xl border border-neutral-200 p-8">
                        <h3 class="mb-5 border-b pb-2 text-2xl font-bold text-neutral-800">
                            <i class="bx bx-receipt mr-2 text-sky-500"></i> Detail Tagihan Pelanggan
                        </h3>

                        {{-- Detail Pelanggan (2 Columns) --}}
                        <div class="mb-6 grid grid-cols-1 gap-x-10 gap-y-3 text-base text-neutral-700 md:grid-cols-2">
                            <p class="border-b pb-2">
                                <span class="font-semibold text-neutral-500">No. Pelanggan:</span>
                                <span class="float-right font-medium text-neutral-800">{{ $billData['number'] }}</span>
                            </p>
                            <p class="border-b pb-2">
                                <span class="font-semibold text-neutral-500">Nama Pelanggan:</span>
                                <span class="float-right font-medium text-neutral-800">{{ $billData['name'] }}</span>
                            </p>
                            <p class="border-b pb-2 md:col-span-2">
                                <span class="font-semibold text-neutral-500">Alamat:</span>
                                <span class="float-right font-medium text-neutral-800">{{ $billData['address'] }}</span>
                            </p>
                            <p class="border-b pb-2">
                                <span class="font-semibold text-neutral-500">Bulan Tagihan:</span>
                                <span
                                      class="float-right font-medium text-neutral-800">{{ $billData['bill_month'] }}</span>
                            </p>
                            <p class="border-b pb-2">
                                <span class="font-semibold text-neutral-500">Jatuh Tempo:</span>
                                <span
                                      class="float-right font-medium text-neutral-800">{{ $billData['due_date'] }}</span>
                            </p>
                        </div>

                        {{-- TOTAL & STATUS --}}
                        <div
                             class="mt-6 flex flex-col items-center justify-between border-t border-sky-200 pt-4 md:flex-row">
                            <div class="mb-4 md:mb-0">
                                <p class="text-sm font-semibold text-neutral-500">Status Pembayaran</p>
                                @if ($billData['status'] == 'Belum Lunas')
                                    <span
                                          class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-700">
                                        <i class="bx bx-x-circle mr-1"></i> {{ $billData['status'] }}
                                    </span>
                                @else
                                    <span
                                          class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                                        <i class="bx bx-check-circle mr-1"></i> {{ $billData['status'] }}
                                    </span>
                                @endif
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-semibold text-neutral-500">Total Tagihan Harus Dibayar</p>
                                <div class="text-3xl font-extrabold text-sky-700">
                                    Rp{{ number_format($billData['amount'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTON --}}
                        @if ($billData['status'] == 'Belum Lunas')
                            <div class="mt-8">
                                <a class="btn primary flex w-full items-center justify-center gap-2 px-6 py-3 text-lg font-bold transition duration-200 hover:shadow-lg"
                                   href="#opsi-bayar">
                                    <i class="bx bx-wallet"></i>
                                    Lanjutkan Pembayaran Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
