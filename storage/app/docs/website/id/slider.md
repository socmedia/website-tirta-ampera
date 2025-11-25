# Slider

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Create Slider](#2-create-slider)
    - [Edit Slider](#3-edit-slider)
    - [Show Slider](#4-show-slider)
    - [Delete Slider](#5-delete-slider)
    - [Update Order](#6-update-order)
3. [Syarat Pengisian Formulir Slider](#syarat-pengisian-formulir-slider)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Slider** digunakan untuk mengelola konten slider yang tampil di halaman depan website, seperti hero banner, promosi, hingga testimoni.  
Administrator dapat menambahkan slider baru, mengedit, menampilkan detail, menghapus, serta mengatur urutan slider dengan drag & drop.

📍 URL: [/panel/slider](/panel/slider)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar slider dengan kolom:

-   **Heading** (multi bahasa sesuai locale aktif)
-   **Link** (meta / button url)
-   **Status** (aktif/tidak aktif)
-   **Created** (tanggal dibuat)
-   **Actions** (show, edit, delete)

Fitur tambahan:

-   **Search** → cari berdasarkan heading.
-   **Sorting** → default `sort_order asc`, bisa diubah.
-   **Filter Tabs** → berdasarkan tipe slider (`hero`, `featured`, `promotion`, `testimonial`, `milestone`, `stores`).
-   **Pagination** → atur jumlah data per halaman.

### 2. Create Slider

Untuk menambahkan slider baru.  
📍 URL: [/panel/slider/create](/panel/slider/create)

### 3. Edit Slider

Mengubah data slider yang sudah ada.  
📍 URL: `/panel/slider/{id}/edit`

-   Semua field sama seperti **Create**, hanya saja datanya sudah terisi dari database.
-   Validasi tetap sama.

### 4. Show Slider

Menampilkan detail slider tertentu.  
📍 URL: `/panel/slider/{id}`

Data yang ditampilkan:

-   Heading & Sub Heading (per bahasa/locale)
-   Description
-   Button Text + Button URL
-   Status (aktif/tidak)
-   Tipe slider
-   Media (gambar desktop/mobile)

### 5. Delete Slider

-   Hapus 1 slider dari tombol action.

Setelah berhasil dihapus, akan muncul notifikasi **“Slider deleted successfully”**.

### 6. Update Order

Administrator bisa mengatur **urutan slider** dengan drag & drop.  
Setelah urutan diperbarui, sistem akan menampilkan notifikasi **“Slider order updated successfully”**.

---

## Syarat Pengisian Formulir Slider

Ketika menambahkan atau mengedit slider, data harus memenuhi syarat berikut:

-   **Status** → boolean (aktif/tidak aktif).
-   **Tipe** → wajib diisi, maksimal 50 karakter. Nilai umum:  
    `hero`, `featured`, `promotion`, `testimonial`, `milestone`, `stores`.
-   **Media** → wajib diisi atau mengupload gambar.
-   **Heading** → wajib diisi, maksimal 191 karakter.
-   **Sub Heading** → opsional, maksimal 50 karakter.
-   **Description** → opsional, maksimal 191 karakter.
-   **Button Text** → opsional, maksimal 100 karakter.
-   **Button URL** → opsional, maksimal 191 karakter.

---

## Catatan

-   Slider mendukung **multi bahasa** melalui field `translations`.
-   Urutan slider berpengaruh pada tampilan frontend.
-   Status menentukan apakah slider ditampilkan atau tidak di halaman website.
