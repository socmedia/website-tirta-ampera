# Access Control – Ikhtisar

## Deskripsi

Modul **Access Control** digunakan untuk mengatur siapa yang dapat mengakses aplikasi dan fitur di dalamnya.  
Dengan modul ini, administrator dapat mengelola **user, role, dan permission** secara fleksibel sehingga keamanan dan pembatasan akses bisa dijaga.

## Tujuan

-   Menyediakan mekanisme otentikasi dan otorisasi yang jelas.
-   Memastikan setiap user hanya dapat mengakses fitur sesuai peran dan izin yang diberikan.
-   Mempermudah pengelolaan hak akses dalam skala besar.

## Konsep Utama

-   **Users** → Individu yang memiliki akun untuk masuk ke sistem.
-   **Roles** → Sekumpulan hak akses yang dikelompokkan (misalnya: _Admin, Editor, Viewer_).
-   **Permissions** → Aksi spesifik yang dapat dilakukan (misalnya: _create post, edit user, delete file_).
-   **Sessions** → Riwayat login user yang berguna untuk audit dan keamanan.

## Alur Dasar

1. Administrator membuat **role** sesuai kebutuhan organisasi.
2. Role diberikan satu atau lebih **permission**.
3. User ditetapkan ke dalam satu atau lebih **role**.
4. Saat user login, sistem akan menentukan izin berdasarkan role & permission.

## Catatan

-   Gunakan role untuk mengelompokkan user dengan tanggung jawab serupa.
-   Hindari memberikan permission langsung ke user individual (lebih baik via role).
-   Selalu cek riwayat **sessions** untuk memantau aktivitas login.
