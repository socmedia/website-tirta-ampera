# Permissions

## Deskripsi

Menu **Permissions** digunakan untuk menampilkan daftar permission yang tersedia di sistem.  
Permission ini biasanya sudah ditentukan di kode atau module, kemudian bisa dikelompokkan dalam **Roles**.

📍 URL: [/panel/access-control/permission](/panel/access-control/permission)

## Fitur Utama

-   **View Listing** → Menampilkan semua permission dengan kolom:
    -   `Name`
    -   `Guard`
    -   `Created`
    -   `Actions`  
        Mendukung pencarian, filter guard, sorting, dan pagination.
-   **Show (opsional)** → Bisa dilihat detailnya saat digunakan di Role.
-   **Delete** → Menghapus permission (baik satuan maupun bulk delete).

## Catatan

-   Permission tidak ditambahkan langsung dari menu ini, melainkan didefinisikan dalam kode/module.
-   Menu ini lebih berfungsi sebagai **viewer** untuk mempermudah administrator melihat permission yang tersedia.
-   Pengelolaan utama dilakukan melalui **Roles**, di mana permission ditugaskan lalu diberikan ke user.
