# Page

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Edit Translation](#2-edit-translation)
3. [Syarat Pengisian Formulir Page](#syarat-pengisian-formulir-page)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Page** digunakan untuk mengelola **konten statis website**, seperti **Syarat & Ketentuan** dan **Kebijakan Privasi**.  
Konten ini dikelompokkan berdasarkan **tab (halaman)** dan **section** di dalamnya.

Contoh:

-   Halaman `About Us` → section `Milestone`, `Team`, `Testimonial`.
-   Halaman `Terms & Conditions` → section `General Terms`, `User Obligations`.

Administrator dapat melakukan pencarian, filter tab/section, mengganti bahasa tampilan, serta mengedit konten terjemahan.

📍 URL: [/panel/page](/panel/page)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar konten statis berdasarkan filter:

-   **Tab** → halaman utama (misalnya: About, Contact, Terms).
-   **Section** → bagian dari halaman (misalnya: Hero, Milestone, Footer).
-   **Locale** → filter berdasarkan bahasa aktif.

Kolom yang tersedia:

-   **Name** → judul/nama konten.
-   **Created** → tanggal dibuat.
-   **Actions** → tombol untuk mengedit translation.

Fitur tambahan:

-   **Search** → mencari berdasarkan keyword.
-   **Pagination** → navigasi daftar konten.
-   **Locale Switcher** → ubah bahasa tampilan.

### 2. Edit Translation

Mengubah isi konten pada section tertentu dalam bahasa tertentu.  
📍 URL: `/panel/page/{id}/edit`

---

## Syarat Pengisian Formulir Page

-   **page** → wajib diisi, string, maksimal 255 karakter.
-   **section** → wajib diisi, string, maksimal 255 karakter.
-   **key** → wajib diisi, string, maksimal 255 karakter, unik di tabel `contents`.
-   **type** → wajib diisi, string, maksimal 50 karakter.
-   **meta** → opsional (metadata tambahan).
-   **translations** → array berisi data multi bahasa:
    -   **name** → wajib diisi, string, maksimal 255 karakter.
    -   **value** → wajib diisi (isi konten sesuai bahasa).

---

## Catatan

-   **Page** bersifat statis, hanya bisa **diedit**, tidak bisa ditambah atau dihapus melalui panel.
-   Setiap konten mendukung **multi bahasa** dengan field `translations`.
-   Tab dan section didapat dari konfigurasi/enum, bukan ditambah manual.
