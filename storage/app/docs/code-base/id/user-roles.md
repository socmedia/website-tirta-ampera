## **Roles and Permissions**

Dokumentasi ini memberikan gambaran rinci tentang **roles** dan **permissions** yang terkait untuk website ARAHCoffee. Role-Based Access Control (RBAC) memastikan setiap pengguna hanya dapat mengakses fitur yang diizinkan, sehingga meningkatkan keamanan dan efisiensi untuk perusahaan yang siap IPO.

---

### **1. User and Access Control**

Access Control mengatur siapa yang dapat **view, create, update, dan delete** user, role, dan permission di dalam sistem.

| **Action**         | **Permission Key**                                        | **Roles Allowed**             |
| :----------------- | :-------------------------------------------------------- | :---------------------------- |
| View ACL Dashboard | `view-acl-dashboard`                                      | Developer, Super Admin        |
| View Permissions   | `view-permission`                                         | Developer, Super Admin        |
| Manage Permissions | `create-permission, update-permission, delete-permission` | Developer                     |
| View Roles         | `view-role`                                               | Developer, Super Admin        |
| Manage Roles       | `create-role, update-role, delete-role`                   | Developer                     |
| View Users         | `view-user`                                               | Developer, Super Admin, Admin |
| Manage Users       | `create-user, update-user, delete-user`                   | Developer, Super Admin        |
| View Sessions      | `view-session`                                            | Developer, Super Admin        |

**Developer** dan **Super Admin** memiliki hierarki kontrol yang ketat terhadap pengaturan keamanan sistem.

---

### **2. Content Management**

Permission Content Management memungkinkan pengguna mengelola konten website seperti post, page, dan blok konten umum.

| **Action**             | **Permission Key**                                                 | **Roles Allowed**             |
| :--------------------- | :----------------------------------------------------------------- | :---------------------------- |
| View Posts             | `view-post`                                                        | Developer, Super Admin, Admin |
| Manage Posts           | `create-post, update-post, delete-post`                            | Developer, Super Admin, Admin |
| Manage Post Categories | `create-post-category, update-post-category, delete-post-category` | Developer, Super Admin, Admin |
| View Pages             | `view-page`                                                        | Developer, Super Admin, Admin |
| Manage Pages           | `create-page, update-page, delete-page`                            | Developer, Super Admin, Admin |
| View Content           | `view-content`                                                     | Developer, Super Admin, Admin |
| Manage Content         | `create-content, update-content, delete-content`                   | Developer, Super Admin, Admin |

**Admin** dan **Super Admin** mengelola konten website, sedangkan **Developer** dapat menangani perubahan struktural.

---

### **3. Product and Store Management**

Permission ini digunakan untuk mengelola katalog produk dan lokasi toko fisik.

| **Action**                | **Permission Key**                                                                                 | **Roles Allowed**             |
| :------------------------ | :------------------------------------------------------------------------------------------------- | :---------------------------- |
| Manage Products           | `view-product, create-product, update-product, delete-product`                                     | Developer, Super Admin, Admin |
| Manage Product Categories | `view-product-category, create-product-category, update-product-category, delete-product-category` | Developer, Super Admin, Admin |
| Manage Stores             | `view-store, create-store, update-store, delete-store`                                             | Developer, Super Admin, Admin |
| Manage Store Categories   | `view-store-category, create-store-category, update-store-category, delete-store-category`         | Developer, Super Admin, Admin |

**Admin** dan **Super Admin** bertanggung jawab memastikan informasi produk dan toko selalu terbaru.

---

### **4. Human Resources & Careers**

Permission pada bagian ini khusus untuk mengelola lowongan pekerjaan dan data pelamar.

| **Action**               | **Permission Key**                                                                             | **Roles Allowed**                      |
| :----------------------- | :--------------------------------------------------------------------------------------------- | :------------------------------------- |
| Manage Careers           | `view-career, create-career, update-career, delete-career`                                     | Developer, Super Admin, Human Resource |
| Manage Career Categories | `view-career-category, create-career-category, update-career-category, delete-career-category` | Developer, Super Admin, Human Resource |
| Manage Applicants        | `view-career-applicants, update-career-applicants, delete-career-applicants`                   | Developer, Super Admin, Human Resource |

Role **Human Resource** memiliki akses khusus ke bagian karir untuk mengelola seluruh kebutuhan rekrutmen.

---

### **5. Investor Relations**

Bagian ini sangat penting untuk perusahaan yang siap IPO, dengan permission untuk mengelola dokumen publik dan keuangan.

| **Action**                 | **Permission Key**                                                             | **Roles Allowed**                      |
| :------------------------- | :----------------------------------------------------------------------------- | :------------------------------------- |
| View Investor Content      | `view-investor`                                                                | Developer, Super Admin, Admin, Finance |
| View Investor Documents    | `view-investor-documents`                                                      | Developer, Super Admin, Admin, Finance |
| Manage Investor Categories | `create-investor-category, update-investor-category, delete-investor-category` | Developer, Super Admin, Admin, Finance |

Tim **Finance** dapat mengelola konten investor yang sensitif dengan aman.

---

### **6. Marketing and Customer Engagement**

Permission ini mengatur materi pemasaran, data pelanggan, dan saluran komunikasi.

| **Action**                    | **Permission Key**                                                                       | **Roles Allowed**             |
| :---------------------------- | :--------------------------------------------------------------------------------------- | :---------------------------- |
| Manage Sliders                | `view-slider, create-slider, update-slider, delete-slider`                               | Developer, Super Admin, Admin |
| Manage Instagram Content      | `view-instagram, create-instagram, update-instagram, delete-instagram`                   | Developer, Super Admin, Admin |
| Manage Collaboration Requests | `view-collaboration-request, update-collaboration-request, delete-collaboration-request` | Developer, Super Admin, Admin |
| Manage Customers              | `view-customer, create-customer, update-customer, delete-customer`                       | Developer, Super Admin, Admin |
| Manage Contact Messages       | `view-contact-message, update-contact-message, delete-contact-message`                   | Developer, Super Admin, Admin |
| Manage SEO                    | `view-seo, create-seo, update-seo, delete-seo`                                           | Developer, Super Admin        |

**Admin** dan **Super Admin** adalah role utama untuk mengelola konten pemasaran dan yang berhubungan langsung dengan pelanggan.

---

### **7. System & Dashboard Access**

Permission ini mengatur akses ke dashboard sistem dan pengaturan inti.

| **Action**         | **Permission Key**                                             | **Roles Allowed**                                      |
| :----------------- | :------------------------------------------------------------- | :----------------------------------------------------- |
| View Dashboard     | `view-dashboard`                                               | Developer, Super Admin, Admin, Finance, Human Resource |
| Manage FAQs        | `view-faq, create-faq, update-faq, delete-faq`                 | Developer, Super Admin, Admin                          |
| Manage Settings    | `view-setting, create-setting, update-setting, delete-setting` | Developer, Super Admin, Admin                          |
| View Notifications | `view-notification`                                            | Developer, Super Admin, Admin                          |

Seluruh personel kunci memiliki akses ke dashboard untuk memantau area tanggung jawab masing-masing.

---

### **Ringkasan Permissions per Role**

| **Role**           | **Permissions**                                                                                                       |
| :----------------- | :-------------------------------------------------------------------------------------------------------------------- |
| **Developer**      | Kontrol penuh atas seluruh sistem, termasuk core permissions dan pengaturan keamanan.                                 |
| **Super Admin**    | Akses penuh ke sebagian besar modul, termasuk manajemen user dan konten, namun tidak dapat mengatur core permissions. |
| **Admin**          | Mengelola konten, produk, toko, pemasaran, dan komunikasi pelanggan.                                                  |
| **Finance**        | Akses khusus ke bagian Investor Relations dan dashboard.                                                              |
| **Human Resource** | Akses khusus untuk mengelola lowongan kerja dan pelamar.                                                              |

Pembagian ini memastikan setiap departemen dapat mengelola tanggung jawabnya secara efisien dan aman.
