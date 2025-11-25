# Post

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Create Post](#2-create-post)
    - [Edit Post](#3-edit-post)
    - [Show Post](#4-show-post)
    - [Delete Post](#5-delete-post)
3. [Syarat Pengisian Formulir Post](#syarat-pengisian-formulir-post)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Post** digunakan untuk mengelola konten artikel pada website.  
Tipe konten dapat berupa:

-   `news`
-   `article`

Administrator dapat menambahkan post baru, mengedit, melihat detail, menghapus, serta melakukan pencarian, filter, sorting, dan pagination.

📍 URL: [/panel/post](/panel/post)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar post dengan kolom:

-   **Title** (multi bahasa sesuai locale aktif)
-   **Author**
-   **Published By**
-   **Status**
-   **Created** (tanggal dibuat)
-   **Actions** (show, edit, delete)

Fitur tambahan:

-   **Search** → cari berdasarkan judul.
-   **Sorting** → default `created_at desc`.
-   **Filter Tabs** → berdasarkan tipe post (`news`, `article`).
-   **Pagination** → atur jumlah data per halaman.
-   **Locale Switcher** → ubah bahasa tampilan listing.

### 2. Create Post

Menambahkan post baru.  
📍 URL: [/panel/post/create](/panel/post/create)

### 3. Edit Post

Mengubah data post yang sudah ada.  
📍 URL: `/panel/post/{id}/edit`

### 4. Show Post

Menampilkan detail post tertentu.  
📍 URL: `/panel/post/{id}`

### 5. Delete Post

Menghapus satu post dari tombol action.  
📍 URL: `/panel/post/{id}/delete`

---

## Syarat Pengisian Formulir Post

-   **Category** → wajib diisi, integer, harus ada di tabel `categories`.
-   **Type** → wajib diisi, string, maksimal 50 karakter.
-   **Thumbnail** → wajib diisi (gambar utama post).
-   **Content** → opsional, tipe string.
-   **Tags** → opsional, string, maksimal 255 karakter.
-   **Translations** → wajib berupa array.
    -   **locale** → wajib diisi, string, maksimal 10 karakter.
    -   **title** → wajib diisi, string, maksimal 191 karakter.
    -   **slug** → wajib diisi, string, maksimal 191 karakter.
    -   **subject** → wajib diisi, string, maksimal 191 karakter.
    -   **content** → wajib diisi, string.

---

## Catatan

-   Post mendukung **multi bahasa** melalui field `translations`.
-   Tipe post (`news`, `article`) berpengaruh pada pengelompokan konten.
-   Default sorting → `created_at desc`.
-   Status post mengatur apakah konten bisa ditampilkan di frontend.
