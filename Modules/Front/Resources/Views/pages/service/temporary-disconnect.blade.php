@extends('front::layouts.master')

@section('title', getContent('seo.temporary_disconnect.title'))

@push('meta')
    <x-front::partials.meta title="Layanan Tutup Sementara Sambungan Air"
                            description="Pengajuan resmi penghentian sementara sambungan air PERUMDA Air Minum Tirta Ampera Boyolali. Prosedur mudah, jelas, dan sesuai ketentuan yang berlaku."
                            keywords="tutup sementara, layanan administrasi, pdam, penutupan sambungan air, tirta ampera boyolali"
                            image="{{ asset('assets/images/service-temporary-disconnect.jpg') }}" />
@endpush

@section('content')
    <x-front::ui.breadcrumb title="Tutup Sementara Sambungan Air" :items="[
        ['label' => __('front::navbar.home'), 'url' => route('front.index')],
        ['label' => __('front::navbar.service'), 'url' => route('front.service.index')],
        ['label' => 'Tutup Sementara Sambungan Air'],
    ]" />

    <section class="py-32">
        <div class="container">

            <!-- HEADER SECTION -->
            <div class="flex w-full flex-col items-center">
                <div class="flex flex-col items-center space-y-4 text-center sm:space-y-6 md:max-w-3xl md:text-center">
                    <p class="badge soft-primary badge-lg rounded-full uppercase">LAYANAN ADMINISTRASI</p>

                    <h2 class="text-3xl font-extrabold text-neutral-900 md:text-5xl">
                        Layanan Tutup Sementara Sambungan Air
                        <span class="text-sky-600">Prosedur Resmi & Mudah</span>
                    </h2>

                    <p class="text-neutral-500 md:max-w-2xl">
                        Layanan Tutup Sementara merupakan penghentian sementara sambungan air atas permohonan resmi
                        pelanggan. Ajukan layanan ini jika Anda tidak akan menggunakan air untuk sementara waktu
                        (misalnya karena rumah kosong, renovasi, atau pindah sementara).
                        <b>Pengajuan layanan dikenakan biaya administrasi sesuai ketentuan PERUMDA Air Minum Tirta Ampera
                            Boyolali.</b>
                    </p>
                </div>
            </div>

            <!-- CARDS SECTION -->
            <div class="mx-auto mt-20 grid max-w-5xl gap-8 md:grid-cols-2">

                {{-- Card: Syarat & Ketentuan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-badge-check text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Syarat & Ketentuan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Layanan ini diperuntukkan bagi pelanggan yang ingin menghentikan sementara pemakaian air
                                    secara resmi.
                                </li>
                                <li>
                                    Permohonan diajukan apabila pelanggan tidak akan menggunakan air dalam jangka waktu
                                    tertentu.
                                </li>
                                <li>
                                    <span class="font-medium text-sky-700">Dikenakan biaya administrasi layanan</span>
                                    sesuai ketentuan PERUMDA Air Minum Tirta Ampera Boyolali.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Syarat Wajib --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-file-detail text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Syarat Wajib</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>
                                    Mengajukan permohonan resmi ke Kantor Unit Pelayanan PERUMDA Air Minum Tirta Ampera
                                    Boyolali.
                                </li>
                                <li>
                                    Melunasi seluruh tagihan dan tunggakan sebelum pengajuan.
                                </li>
                                <li>
                                    Membayar biaya administrasi layanan Tutup Sementara sesuai ketentuan.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Prosedur Pengajuan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-check-circle text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Prosedur Pengajuan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>Pelanggan datang ke Unit Pelayanan dan mengajukan permohonan Tutup Sementara.</li>
                                <li>Petugas melakukan verifikasi data dan status tagihan.</li>
                                <li>Petugas menyampaikan informasi besaran biaya administrasi.</li>
                                <li>Pelanggan melakukan pembayaran biaya administrasi layanan.</li>
                                <li>Petugas menjadwalkan dan melaksanakan penutupan sambungan air di lokasi pelanggan.</li>
                                <li class="mt-2">
                                    Setelah memahami dan menyetujui seluruh informasi di atas, silakan klik tombol untuk
                                    melanjutkan proses pengajuan.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Card: Informasi Tambahan --}}
                <div
                     class="rounded-lg bg-gradient-to-r from-sky-500/20 via-cyan-200/40 to-lime-200/40 p-0.5 transition transition-colors hover:from-lime-200/40 hover:via-cyan-200/40 hover:to-sky-500/20">
                    <div class="flex h-full flex-col rounded-lg bg-white p-6">
                        <span class="mb-7 flex size-12 items-center justify-center rounded-xl bg-sky-600/10">
                            <i class="bx bx-info-circle text-3xl text-sky-600"></i>
                        </span>
                        <div>
                            <h3 class="mb-2 text-lg font-medium text-neutral-900 md:text-xl">Informasi Tambahan</h3>
                            <ul class="text-md list-disc space-y-2 pl-4 text-neutral-500">
                                <li>Tutup Sementara tidak menghapus status pelanggan dan dapat dibuka kembali sesuai
                                    prosedur.</li>
                                <li>Untuk penjelasan lebih lanjut, hubungi Customer Service atau Unit Pelayanan terdekat.
                                </li>
                                <li>Seluruh proses bersifat resmi, terdokumentasi, dan sesuai ketentuan yang berlaku.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <x-front::partials.cta.apps-secondary />
@endsection
