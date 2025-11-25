# FAQ (Investor)

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Create](#2-create)
    - [Edit](#3-edit)
    - [Show](#4-show-optional)
    - [Delete](#5-delete)
    - [Reorder](#6-reorder)
3. [Syarat Pengisian Formulir FAQ](#syarat-pengisian-formulir-faq)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **FAQ (Investor)** digunakan untuk mengelola daftar pertanyaan yang sering diajukan oleh publik maupun investor.  
Admin dapat menambahkan pertanyaan & jawaban dalam berbagai bahasa, menentukan status (aktif/tidak aktif), serta menandai FAQ tertentu sebagai **Featured**.

📍 URL: [/panel/investor/faq](/panel/investor/faq)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar FAQ dengan filter status dan bahasa.

Kolom yang tersedia:

-   **Question** → pertanyaan utama (multi bahasa).
-   **Status** → aktif/tidak aktif.
-   **Featured** → ditandai sebagai unggulan atau tidak.
-   **Created** → tanggal dibuat.
-   **Actions** → edit, show, atau delete.

Fitur tambahan:

-   **Search** → pencarian berdasarkan keyword pertanyaan.
-   **Pagination** → navigasi daftar FAQ.
-   **Locale Switcher** → ubah bahasa tampilan.
-   **Tabs** → filter berdasarkan status FAQ.

### 2. Create

Menambahkan pertanyaan baru ke dalam daftar FAQ.  
📍 URL: `/panel/investor/faq/create`

### 3. Edit

Mengubah data FAQ yang sudah ada.  
📍 URL: `/panel/investor/faq/{id}/edit`

### 4. Show (Optional)

Menampilkan detail FAQ termasuk semua terjemahannya.  
📍 URL: `/panel/investor/faq/{id}`

### 5. Delete

Menghapus satu FAQ tertentu.

### 6. Reorder

Mengatur urutan FAQ dengan **drag & drop** sesuai kebutuhan.

---

## Syarat Pengisian Formulir FAQ

-   **status** → boolean (true/false), menentukan apakah FAQ tampil di website.
-   **featured** → boolean, tandai jika FAQ perlu ditampilkan di bagian khusus.
-   **category** → wajib dipilih, opsi:
    -   `Umum`
    -   `Investor & Keuangan`
    -   `Informasi Investor`
-   **translations** → array multi bahasa berisi:
    -   **question** → wajib diisi, string, maksimal 255 karakter.
    -   **answer** → wajib diisi, string, maksimal 2000 karakter.

---

## Catatan

-   FAQ mendukung **multi bahasa**.
-   FAQ hanya dapat **ditambahkan, diedit, ditampilkan, dihapus, dan diurutkan**.
-   Tidak ada fitur **bulk delete**.
-   Gunakan kategori agar FAQ lebih terstruktur dan mudah ditemukan.
