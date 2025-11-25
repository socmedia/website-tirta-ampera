## **Pendahuluan**

### **Tentang Proyek Ini**

Membangun website untuk brand seperti **ARAHCoffee**—yang sedang mempersiapkan diri menjadi perusahaan berstandar IPO (Initial Public Offering)—berarti menciptakan platform yang tidak hanya menarik secara visual, tetapi juga memenuhi standar profesionalisme, transparansi, dan kredibilitas yang diharapkan dari sebuah perusahaan publik.

Proyek ini dikembangkan dengan fokus mendukung perjalanan ARAHCoffee menuju kesiapan IPO, memastikan website ini menjadi fondasi digital yang kuat untuk hubungan investor, komunikasi publik, dan pertumbuhan brand.

---

### **Persyaratan Sistem**

Untuk memastikan aplikasi berjalan lancar serta menjaga standar keamanan dan performa yang tinggi, pastikan lingkungan Anda memiliki:

-   **[PHP 8.2 atau lebih baru](https://www.php.net/downloads)** – Bahasa pemrograman utama aplikasi ini.
-   **[Composer](https://getcomposer.org/download/)** – Pengelola dependensi untuk PHP.
-   **[Node.js](https://nodejs.org/en/download/)** – Diperlukan untuk dependensi frontend dan alat build.

---

### **Panduan Instalasi**

Ikuti langkah-langkah berikut untuk menyiapkan dan menjalankan aplikasi di komputer lokal Anda:

| Langkah                          | Perintah                                           |
| -------------------------------- | -------------------------------------------------- |
| **Clone repository**             | `git@github.com:morphling-dev/ipo-arah-coffee.git` |
| **Install dependensi PHP**       | `composer install`                                 |
| **Salin file environment**       | `cp .env.example .env`                             |
| **Generate application key**     | `php artisan key:generate`                         |
| **Jalankan migrasi & seed data** | `php artisan migrate --seed`                       |
| **Install dependensi Node.js**   | `npm install` atau `yarn install`                  |
| **Jalankan aplikasi**            | `php artisan serve`                                |

Setelah selesai, aplikasi Anda seharusnya dapat diakses melalui **`http://localhost:8000`**.

---

### **Dependensi Utama**

#### **Dependensi Composer (PHP)**

Proyek ini menggunakan stack Laravel modern dan paket pihak ketiga terpercaya untuk memastikan keandalan, skalabilitas, dan kemudahan pemeliharaan—sangat penting untuk website brand yang siap IPO.

**Paket Inti Laravel & Resmi:**

-   [Laravel Framework](https://laravel.com/) – Tulang punggung proyek.
-   [Livewire](https://livewire.laravel.com/) – UI reaktif tanpa JavaScript.
-   [Laravel Octane](https://laravel.com/docs/12.x/octane) – Server berperforma tinggi.
-   [Laravel Pulse](https://laravel.com/docs/12.x/pulse) – Monitoring performa aplikasi.
-   [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum) – Autentikasi API.
-   [Laravel Tinker](https://laravel.com/docs/12.x/artisan#tinker) – REPL untuk Laravel.

**Paket Pihak Ketiga Penting:**

-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction) – Manajemen peran & izin.
-   [Spatie Laravel Analytics](https://spatie.be/docs/laravel-analytics/v5/introduction) – Integrasi Google Analytics.
-   [Spatie Temporary Directory](https://github.com/spatie/temporary-directory) – Manajemen file sementara.
-   [Nwidart Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction) – Arsitektur modular.
-   [mhmiton Laravel Modules Livewire](https://github.com/mhmiton/laravel-modules-livewire) – Dukungan Livewire untuk modul.
-   [Barryvdh Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf) – Pembuatan PDF.
-   [Dompdf](https://github.com/dompdf/dompdf) – Library rendering PDF.
-   [SpartnerNL Laravel Excel](https://laravel-excel.com/) – Ekspor/impor Excel.
-   [Whitecube PHP Prices](https://github.com/whitecube/php-prices) – Perhitungan harga.
-   [Brick Money](https://github.com/brick/money) – Manajemen uang & mata uang.
-   [Brick PhoneNumber](https://github.com/brick/phonenumber) – Format & validasi nomor telepon.
-   [Dasundev Livewire Dropzone](https://github.com/dasundev/livewire-dropzone) – Upload file dengan Livewire.
-   [Doctrine DBAL](https://www.doctrine-project.org/projects/dbal.html) – Lapisan abstraksi database.
-   [GuzzleHTTP](https://docs.guzzlephp.org/en/stable/) – HTTP client untuk permintaan API.
-   [Inertia.js Laravel Adapter](https://inertiajs.com/client-side-setup) – Dukungan SPA.
-   [Intervention Image](https://image.intervention.io/) – Pengelolaan & manipulasi gambar.
-   [Jenssegers Agent](https://github.com/jenssegers/agent) – Deteksi user agent.
-   [Opcodesio Log Viewer](https://github.com/opcodesio/log-viewer) – Melihat file log.
-   [Stichoza Google Translate PHP](https://github.com/Stichoza/google-translate-php) – API Google Translate.
-   [Stripe PHP](https://github.com/stripe/stripe-php) – Integrasi pembayaran Stripe.

---

#### **Dependensi Node.js**

Alat-alat berikut digunakan untuk mengelola aset frontend dan memberikan pengalaman pengguna yang modern, responsif, dan mudah diakses—penting untuk brand yang ingin IPO:

-   [Laravel Mix](https://laravel-mix.com/) – Kompilasi & bundling aset.
-   [Alpine.js](https://alpinejs.dev/) – Framework JavaScript ringan.
-   [Axios](https://axios-http.com/docs/intro) – HTTP client untuk permintaan API.
-   [Tailwind CSS](https://tailwindcss.com/) – Framework CSS utility-first.
-   [PostCSS](https://postcss.org/) – Pemrosesan & optimasi CSS.
-   [Sass](https://sass-lang.com/) – Preprocessor CSS untuk styling.

---

### **Lisensi**

&copy; 2025 **ARAHCoffee**. All Rights Reserved.

Proyek ini bersifat proprietary dan hanya ditujukan untuk transformasi digital IPO ARAHCoffee. Distribusi atau penggunaan tanpa izin tertulis secara eksplisit sangat dilarang.
