# Profile

## Table of Content

1. [Deskripsi](#deskripsi)
2. [Fitur Utama](#fitur-utama)

    - [Account](#1-account)
    - [Preference](#2-preference)
    - [Security / Password](#3-security--password)

3. [Syarat Pengisian Formulir Profile](#syarat-pengisian-formulir-profile)
4. [Catatan](#catatan)

---

## Deskripsi

Menu **Profile** digunakan untuk mengelola informasi akun pengguna pada aplikasi.
Terdiri dari 3 bagian utama:

-   **Account** → update nama, email, dan avatar.
-   **Preference** → pengaturan tema (light/dark mode).
-   **Security / Password** → ubah password akun.

📍 URL: [/panel/account](/panel/account)

---

## Fitur Utama

### 1. Account

Mengelola informasi akun pengguna.

📍 URL: [/panel/account](/panel/account)

Fitur:

-   Update nama dan email.
-   Upload / ganti avatar.
-   Hapus akun (dengan validasi password).
-   Event **avatarChanged** untuk update UI setelah avatar diperbarui.

### 2. Preference

Mengatur tampilan aplikasi (tema).

📍 URL: [/panel/preference](/panel/preference)

Fitur:

-   Pilih **Light Mode**.
-   Pilih **Dark Mode**.
-   Tema disimpan dalam state `$store.ui`.

### 3. Security / Password

Mengatur keamanan akun dengan mengganti password.

📍 URL: [/panel/security](/panel/security)

Fitur:

-   Input **Current Password** (validasi wajib).
-   Input **New Password**.
-   Input **Confirm New Password**.
-   Tombol update password dengan spinner loader.
-   Toggle **show/hide password** menggunakan ikon `bx-eye`.

---

## Syarat Pengisian Formulir Profile

### Account

-   **Name** → wajib, string, maksimal 191 karakter.
-   **Email** → wajib, email valid, unik.
-   **Avatar** → opsional, file gambar (jika ada menggantikan avatar lama).
-   **Current Password** → wajib saat hapus akun.

### Preference

-   **Theme** → wajib, string, hanya `light` atau `dark`.

### Security / Password

-   **Current Password** → wajib, string, minimal 8 karakter.
-   **Password** → wajib, string, minimal 8 karakter.
-   **Password Confirmation** → wajib, harus sama dengan `password`.

---

## Catatan

-   Avatar lama akan dihapus otomatis ketika mengganti dengan avatar baru.
-   Saat menghapus akun, sistem akan otomatis logout dan redirect ke halaman login.
-   Preference (tema) disimpan di frontend menggunakan Alpine Store (`$store.ui`).
-   Validasi password mengikuti rule bawaan Laravel `current_password:web`.
-   Semua form menggunakan **Livewire** dengan dukungan validasi real-time.
