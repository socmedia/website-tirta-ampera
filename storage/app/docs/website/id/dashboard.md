# Dashboard

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Widget Ringkas](#widget-ringkas)
    - [Collaboration](#1-collaboration)
    - [Contact Message](#2-contact-message)
    - [Applicant](#3-applicant)
    - [Visitor](#4-visitor)
3. [Chart](#chart)
    - [Visitor Chart](#1-visitor-chart)
    - [Device Chart](#2-device-chart)
4. [Date Range](#date-range)
5. [Catatan](#catatan)

---

## Deskripsi

Menu **Dashboard** menampilkan ringkasan data utama dan analitik website.  
Administrator dapat melihat statistik singkat (widget) serta visualisasi data berupa grafik.  
Semua data dapat difilter berdasarkan **rentang tanggal** menggunakan date range picker.

📍 URL: [/panel](/panel)

---

## Widget Ringkas

Widget menampilkan data dalam bentuk angka ringkas. Ditampilkan dalam grid 4 kolom.

### 1. Collaboration

-   Menampilkan jumlah permintaan kolaborasi yang masuk pada periode terpilih.

### 2. Contact Message

-   Menampilkan jumlah pesan kontak yang diterima melalui form website.

### 3. Applicant

-   Menampilkan jumlah pelamar kerja yang masuk.

### 4. Visitor

-   Menampilkan total pengunjung website berdasarkan data Google Analytics.

---

## Chart

Selain widget, Dashboard juga menyajikan grafik analitik.

### 1. Visitor Chart

-   Menampilkan tren jumlah pengunjung dalam periode yang dipilih.
-   Data diambil dari Google Analytics (screen page views / users).
-   Ditampilkan dalam grafik garis atau area chart.

### 2. Device Chart

-   Menampilkan distribusi pengunjung berdasarkan **Operating System (OS)**.
-   Menggunakan data Google Analytics `fetchTopOperatingSystems`.
-   Default menampilkan **5 OS teratas**.
-   Data disajikan dalam bentuk pie/donut chart.

## Date Range

-   **Date Range Picker** tersedia di bagian atas dashboard.
-   User dapat memilih tanggal awal (`start`) dan tanggal akhir (`end`).
-   Jika hanya memilih 1 hari, ditampilkan sebagai **on {tanggal}**.
-   Jika memilih rentang, ditampilkan sebagai **from {tanggal} to {tanggal}**.
-   Default (jika kosong) → 7 hari terakhir.
-   Setiap perubahan range akan memicu update ke semua widget & chart.

---

## Catatan

-   Dashboard hanya menampilkan data **read-only**, tidak ada aksi CRUD.
-   Data visitor & device chart sepenuhnya berasal dari **Google Analytics**.
-   Disarankan menggunakan **caching** pada layer service untuk mengurangi jumlah request API ke Google Analytics.
-   Semua data sinkron dengan `dateRange` sehingga konsisten antar widget & chart.
