# Roles

## Deskripsi

Menu **Roles** digunakan untuk mengelompokkan hak akses (permissions) yang bisa diberikan ke user.  
Dengan role, administrator dapat lebih mudah mengatur otorisasi tanpa harus menetapkan permission satu per satu ke user.

📍 URL: [/panel/access-control/role](/panel/access-control/role)

## Fitur Utama

-   **View Listing** → Menampilkan semua role dengan kolom:
    -   `Name`
    -   `Total Permission`
    -   `Guard`
    -   `Created`
    -   `Actions`  
        Mendukung pencarian, filter guard, sorting, dan pagination.
-   **Edit** → Ubah informasi role, termasuk menambahkan atau menghapus permission yang terkait.
-   **Show (opsional)** → Lihat detail role lengkap beserta daftar permission yang melekat.

## Validasi Form

-   **Name** → Wajib, minimal 3 karakter, unik per guard.
-   **Guard Name** → Wajib, harus sesuai dengan daftar guard yang tersedia.

## Catatan

-   Role adalah cara paling efisien untuk mengatur permission dalam jumlah banyak.
-   Satu user bisa memiliki lebih dari satu role.
-   Hapus role dengan hati-hati, terutama jika sudah banyak user yang menggunakannya.
