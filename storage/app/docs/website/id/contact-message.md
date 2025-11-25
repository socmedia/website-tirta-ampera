# Contact Message

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)
    - [View Listing](#1-view-listing)
    - [Show Message](#2-show-message)
    - [Mark as Seen / Unseen](#3-mark-as-seen--unseen)
    - [Delete Message](#4-delete-message)
    - [Export](#5-export)
3. [Catatan](#catatan)

---

## Deskripsi

Menu **Contact Message** digunakan untuk mengelola pesan masuk dari form **Contact Us** atau sumber komunikasi lain yang terintegrasi.

Administrator dapat melakukan:

-   Melihat daftar pesan masuk.
-   Membuka detail pesan tertentu.
-   Menandai pesan sebagai **seen** atau **unseen**.
-   Menghapus pesan.
-   Mengekspor data pesan (xlsx, csv).

📍 URL: [/panel/public-message](/panel/public-message)

---

## Fitur Utama

### 1. View Listing

Menampilkan daftar pesan dengan filter:

-   **Tab** → `All`, `Seen`, `Unseen`.
-   **Search** → pencarian berdasarkan nama/email/subject.
-   **Pagination / Infinite Scroll** → daftar akan otomatis memuat lebih banyak data saat scroll mendekati akhir.

Kolom yang tersedia di listing:

-   **Name/Email** → pengirim pesan.
-   **Subject** → judul pesan (atau "No Subject" jika kosong).
-   **Message (excerpt)** → ringkasan isi pesan.
-   **Created At** → waktu pesan masuk.

### 2. Show Message

Menampilkan detail pesan ketika dipilih dari sidebar. Informasi yang ditampilkan:

-   **Subject** → judul pesan.
-   **From** → nama dan email pengirim.
-   **Date** → waktu pesan dikirim.
-   **Message** → isi lengkap pesan.

Selain itu tersedia tombol cepat:

-   **Email** → membuka aplikasi email untuk membalas.
-   **WhatsApp** → jika tersedia nomor WhatsApp, langsung membuka chat ke pengirim.

### 3. Mark as Seen / Unseen

-   **Mark as Seen** → menandai pesan belum terbaca menjadi terbaca.
-   **Mark as Unseen** → menandai pesan terbaca menjadi belum terbaca.

Pesan otomatis ditandai sebagai **seen** ketika dibuka.

### 4. Delete Message

Pesan dapat dihapus dengan tombol **Remove**.

-   Setelah dihapus, pesan akan hilang dari daftar.
-   Aksi ini hanya tersedia bagi user dengan izin **delete-contact-message**.

### 5. Export

Data pesan dapat diekspor dalam beberapa format:

-   **.xlsx**
-   **.csv**

Export akan menggunakan filter yang sedang aktif (tab & search).  
Proses ekspor memanfaatkan **Laravel Excel (Maatwebsite/Excel)**.

---

## Catatan

-   Pesan hanya bisa **dilihat**, **diberi status (seen/unseen)**, **dihapus**, dan **diekspor**.
-   Pesan tidak bisa dibuat atau diubah dari panel (hanya datang dari user melalui form Contact).
-   Infinite scroll digunakan untuk memuat pesan berikutnya, menggantikan pagination klasik.
-   Aksi sensitif (delete) memerlukan konfirmasi modal.
-   Hak akses dikontrol melalui **permission** (`view-contact-message`, `update-contact-message`, `delete-contact-message`).
