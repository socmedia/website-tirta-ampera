# Category

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Filter by Group & Status](#2-filter-by-group--status)
    - [Show Category](#3-show-category)
    - [Update Order](#4-update-order)
    - [Delete Category](#5-delete-category)
3. [Syarat Pengisian Formulir Category](#syarat-pengisian-formulir-category)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Category** digunakan untuk mengelola daftar kategori pada berbagai **group** yang tersedia.  
Kategori berfungsi sebagai pengelompokan data, misalnya: produk, postingan, dokumen investor, FAQ, dan lainnya.

📍 URL: [/panel/{page}/category](/panel/{page}/category)

Tersedia beberapa group kategori bawaan:

-   **departments**
-   **investor_documents**
-   **faqs**
-   **notifications**
-   **posts**
-   **products**
-   **stores**

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar kategori berdasarkan filter yang dipilih.  
Kolom yang tersedia:

-   **Name** → nama kategori (multi bahasa).
-   **Description** → deskripsi kategori.
-   **Status** → status aktif/tidak aktif.
-   **Featured** → apakah kategori ditandai sebagai unggulan.
-   **Created** → tanggal dibuat.
-   **Action** → tombol aksi (edit, hapus, lihat).

Fitur tambahan:

-   **Search** → pencarian berdasarkan nama/deskripsi.
-   **Sorting** → urutkan berdasarkan kolom (name, status, featured, created).
-   **Pagination** → navigasi halaman data kategori.

### 2. Filter by Group & Status

-   **Group** → memfilter kategori berdasarkan kelompoknya (misalnya hanya `products` atau `faqs`).
-   **Status** → memfilter kategori berdasarkan status (`all`, `active`, `inactive`).

Tab group juga menampilkan jumlah kategori di setiap group.

### 3. Show Category

Menampilkan detail kategori yang dipilih, termasuk subkategori jika ada.  
Detail ini diambil dari `CategoryService::findByIdWithSubcategories`.

### 4. Update Order

Kategori dapat diurutkan ulang dengan **drag & drop**.  
Perubahan urutan akan disimpan ke database melalui `CategoryService::updateOrder`.

Jika sedang membuka detail kategori, urutan subkategori juga akan diperbarui otomatis.

### 5. Delete Category

Kategori dapat dihapus dengan tombol **Delete**.  
Setelah dihapus, kategori akan hilang dari daftar.

Aksi ini hanya tersedia bagi user dengan izin **delete-category**.

---

## Syarat Pengisian Formulir Category

-   **group** → wajib diisi, string.
-   **meta** → opsional (metadata tambahan).
-   **featured** → boolean, default `false`.
-   **translations** → array multi bahasa:
    -   **name** → wajib diisi, string, maksimal 255 karakter.
    -   **description** → opsional, string, maksimal 1000 karakter.

---

## Catatan

-   **Category** tersedia untuk berbagai group (`departments`, `investor_documents`, `faqs`, `notifications`, `posts`, `products`, `stores`).
-   Mendukung **multi bahasa** melalui field `translations`.
-   **Order kategori** dapat diubah dengan drag & drop.
-   Aksi sensitif (delete) memerlukan konfirmasi.
-   Hak akses dikontrol dengan permission:
    -   `create-{page}-category`
    -   `update-{page}-category`
    -   `delete-{page}-category`
