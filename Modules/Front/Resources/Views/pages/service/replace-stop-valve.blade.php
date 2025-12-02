@extends('front::layouts.master')

@section('title', getContent('seo.replace_stop_valve.title'))

@push('meta')
    <x-front::partials.meta title="Ganti Stop Kran"
                            description="Pengajuan layanan penggantian Stop Kran PDAM Tirta Amperaku secara online. Proses mudah, biaya transparan, dan dikerjakan teknisi profesional."
                            keywords="ganti stop kran, penggantian stop kran, layanan stop kran, pdam online, tirta Amperaku"
                            image="{{ asset('assets/images/replace-stop-valve.jpg') }}" />
@endpush

@section('content')
    <x-front::ui.breadcrumb title="Ganti Stop Kran" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.service'), 'url' => route('front.service.index')],
        ['label' => 'Ganti Stop Kran'],
    ]" />

    <section class="py-32">
        <div class="container">
            <div class="flex w-full flex-col items-center">
                <div class="flex flex-col items-center space-y-4 text-center sm:space-y-6 md:max-w-3xl md:text-center">
                    <p class="badge soft-primary badge-lg rounded-full uppercase">LAYANAN PERBAIKAN</p>
                    <h2 class="text-3xl font-extrabold text-neutral-900 md:text-5xl">
                        Ganti Stop Kran? <span class="text-sky-600">Bisa Online!</span>
                    </h2>
                    <p class="text-neutral-500 md:max-w-2xl">
                        Stop kran di rumah Anda bocor atau rusak? Ajukan penggantian langsung lewat aplikasi <b
                           class="text-sky-700">Tirta Amperaku</b> atau ke Unit Pelayanan. Biaya transparan, pengerjaan
                        cepat oleh teknisi profesional.
                    </p>
                </div>
            </div>

            <div class="mx-auto mt-20 grid max-w-5xl gap-8 md:grid-cols-2">
                {{-- Card: Syarat & Lingkup --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-badge-check text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Syarat & Lingkup</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Layanan hanya untuk penggantian <span class="font-medium text-sky-700">Stop Kran
                                        Utama</span> yang rusak di lokasi meter air.
                                </li>
                                <li>
                                    Pelanggan harus <span class="font-medium">tidak memiliki tunggakan</span>
                                    tagihan.
                                </li>
                                <li>
                                    Kerusakan/pekerjaan di pipa setelah meter bukan tanggung jawab layanan ini.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Dokumen & Pengajuan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-file text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Dokumen & Pengajuan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Lengkapi form permohonan penggantian (<span class="font-medium text-sky-700">langsung di
                                        aplikasi atau Unit</span>).
                                </li>
                                <li>
                                    Bukti pembayaran tagihan air terakhir.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Biaya Layanan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-wallet text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Biaya Layanan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Biaya tergantung jenis/ukuran stop kran dan material yang dibutuhkan.
                                </li>
                                <li>
                                    <span class="font-medium text-sky-700">Rincian biaya dikonfirmasi setelah survei
                                        lokasi</span> atau melalui aplikasi.
                                </li>
                                <li>
                                    Biaya perbaikan tambahan jika ditemukan kerusakan lain.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Proses & Jaminan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-shield-alt-2 text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Proses Layanan & Jaminan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Teknisi survei dan konfirmasi biaya.
                                </li>
                                <li>
                                    <span class="font-medium">Pembayaran sesuai rincian biaya.</span>
                                </li>
                                <li>
                                    <span class="font-medium text-sky-700">Pengerjaan langsung oleh teknisi resmi
                                        PDAM</span> dengan garansi material & pekerjaan.
                                </li>
                                <li>
                                    Semua transaksi transparan lewat sistem resmi PDAM.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-front::partials.cta.apps-secondary />
@endsection
