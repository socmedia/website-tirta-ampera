# Users

## Deskripsi

Menu **Users** digunakan untuk mengelola akun pengguna yang memiliki akses ke sistem.  
Administrator dapat membuat, mengubah, menghapus, serta menetapkan role ke setiap user sesuai kebutuhan.

📍 URL: [/panel/access-control/user](/panel/access-control/user)

## Fitur Utama

-   **View Listing** → Menampilkan semua user dengan kolom `Name`, `Email`, `Roles`, `Created`, dan `Actions`.  
    Mendukung pencarian, filter guard, sorting, dan pagination.
-   **Create** → Tambah user baru dengan data:
    -   Nama lengkap
    -   Email (unik)
    -   Password & konfirmasi password
    -   Role (dapat lebih dari satu)
-   **Edit** → Ubah informasi user yang sudah ada, termasuk reset password dan update role.
-   **Show (opsional)** → Lihat detail user lengkap beserta role yang dimiliki.
-   **Delete** → Hapus user secara individual atau beberapa sekaligus (bulk delete).

## Validasi Form

-   **Name** → Wajib, minimal 3 karakter
-   **Email** → Wajib, format email valid, harus unik
-   **Password** → Wajib, minimal 8 karakter, dikonfirmasi
-   **Roles** → Opsional, dapat lebih dari satu, harus sesuai dengan role yang ada

## Catatan

-   Password dapat dikonfigurasi lebih ketat (kombinasi huruf besar, angka, simbol).
-   Sebaiknya setiap user minimal memiliki **satu role**.
-   Gunakan fitur bulk delete dengan hati-hati karena data yang dihapus tidak dapat dipulihkan.
