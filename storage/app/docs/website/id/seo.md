# SEO

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Edit SEO](#2-edit-seo)
3. [Syarat Pengisian Formulir SEO](#syarat-pengisian-formulir-seo)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **SEO** digunakan untuk mengelola data SEO (Search Engine Optimization) pada website.  
Data SEO dikelompokkan berdasarkan **page** dan **section** (jika ada), untuk mengatur meta tag, judul, deskripsi, dan data SEO lainnya per halaman.

Contoh:

-   Page: `Home`, `About Us`, `Contact`
-   Section: `Hero`, `Footer` (opsional, jika SEO per section)

Administrator dapat melakukan pencarian, filter page/section, mengganti bahasa tampilan, serta mengedit data SEO multi bahasa.

📍 URL: [/panel/seo](/panel/seo)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar data SEO berdasarkan filter:

-   **Page** → halaman utama (misalnya: Home, About, Contact).
-   **Section** → bagian dari halaman (jika ada, misal: Hero, Footer).
-   **Locale** → filter berdasarkan bahasa aktif.

Kolom yang tersedia:

-   **Title** → judul SEO (per bahasa).
-   **Created** → tanggal dibuat.
-   **Actions** → tombol untuk mengedit SEO.

Fitur tambahan:

-   **Search** → mencari berdasarkan keyword.
-   **Pagination** → navigasi daftar SEO.
-   **Locale Switcher** → ubah bahasa tampilan.

### 2. Edit SEO

Mengubah data SEO pada page/section tertentu dalam bahasa tertentu.  
📍 URL: `/panel/seo/{id}/edit`

Administrator dapat:

-   Mengubah **title** (judul SEO) sesuai bahasa.
-   Mengubah **description** (meta description) sesuai bahasa.
-   Mengubah **keywords** (meta keywords) sesuai bahasa.
-   Menyimpan perubahan SEO langsung dari listing.

---

## Syarat Pengisian Formulir SEO

-   **page** → wajib diisi, string, maksimal 255 karakter.
-   **section** → opsional, string, maksimal 255 karakter.
-   **key** → wajib diisi, string, maksimal 255 karakter, unik di tabel `seo`.
-   **type** → wajib diisi, string, maksimal 50 karakter (misal: `meta`, `og`, `twitter`).
-   **meta** → opsional (metadata tambahan).
-   **translations** → array berisi data multi bahasa:
    -   **title** → wajib diisi, string, maksimal 255 karakter.
    -   **description** → opsional, string, maksimal 500 karakter.
    -   **keywords** → opsional, string, maksimal 255 karakter.

---

## Catatan

-   **SEO** hanya bisa **diedit**, tidak bisa **ditambah** atau **dihapus** melalui panel.
-   Setiap data SEO mendukung **multi bahasa** dengan field `translations`.
-   Page dan section didapat dari konfigurasi/enum, bukan ditambah manual.
-   Listing data menggunakan **SeoService** dengan filter: search, sort, page, section, locale, dan pagination.
