# Content

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Edit Translation](#2-edit-translation)
3. [Syarat Pengisian Formulir Content](#syarat-pengisian-formulir-content)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Content** digunakan untuk mengelola konten statis pada website.  
Konten dikelompokkan berdasarkan **tab (page)** dan **section** di dalamnya.

Contoh:

-   Page: `About Us`
-   Section: `Milestone`, `Team`, `Testimonial`

Administrator dapat melakukan pencarian, filter tab/section, mengganti bahasa tampilan, serta mengedit konten terjemahan.

📍 URL: [/panel/content](/panel/content)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar konten statis berdasarkan filter:

-   **Tab** → halaman utama (misalnya: About, Contact, Home).
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
📍 URL: `/panel/content/{id}/edit`

Administrator dapat:

-   Mengubah **name** (judul konten) sesuai bahasa.
-   Mengubah **value** (isi konten) sesuai bahasa.
-   Menyimpan perubahan terjemahan langsung dari listing.

---

## Syarat Pengisian Formulir Content

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

-   **Content** bersifat statis → hanya bisa **diedit**, tidak bisa **ditambah** atau **dihapus** melalui panel.
-   Setiap konten mendukung **multi bahasa** dengan field `translations`.
-   Tab dan section didapat dari konfigurasi/enum, bukan ditambah manual.
-   Listing data menggunakan **ContentService** dengan filter: search, sort, tab, section, locale, dan pagination.
