## **Panduan Konfigurasi**

Dokumen ini memberikan gambaran mengenai konfigurasi environment (`.env`) untuk **ARAHCoffee – IPO Website**.
Variabel-variabel environment ini menentukan bagaimana aplikasi dijalankan, mencakup koneksi database, logging, caching, mail services, integrasi pihak ketiga, dan lainnya.

---

### **Application Settings**

Konfigurasi umum untuk environment aplikasi dan pengaturan dasar.

```ini
APP_NAME="ARAHCoffee - IPO Website"
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

* `APP_NAME` – Nama aplikasi yang ditampilkan.
* `APP_ENV` – Lingkungan aplikasi (`local`, `staging`, `production`).
* `APP_KEY` – Kunci enkripsi internal (tidak boleh diubah setelah di-generate).
* `APP_DEBUG` – Mengaktifkan pesan error detail (`true` untuk development, `false` untuk production).
* `APP_URL` – Base URL aplikasi.

---

### **Logging Configuration**

Mengatur bagaimana log aplikasi disimpan dan dikelola.

```ini
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

* `LOG_CHANNEL` – Driver log default (`stack`, `single`, `daily`).
* `LOG_LEVEL` – Level minimum pesan log yang dicatat (`debug`, `info`, `warning`, `error`, dll).

---

### **Database Configuration**

Detail koneksi database aplikasi.

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arahcoffee_web
DB_USERNAME=root
DB_PASSWORD=
```

* `DB_CONNECTION` – Jenis driver database (`mysql`, `pgsql`, `sqlite`).
* `DB_HOST` – Alamat host database server.
* `DB_PORT` – Port database (default: `3306` untuk MySQL).
* `DB_DATABASE` – Nama database.
* `DB_USERNAME` – Username database.
* `DB_PASSWORD` – Password database.

---

### **Caching & Session**

Konfigurasi caching dan session handling.

```ini
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

* `CACHE_DRIVER` – Mekanisme cache (`file`, `redis`, `database`, `memcached`).
* `QUEUE_CONNECTION` – Driver queue (`sync`, `database`, `redis`).
* `SESSION_DRIVER` – Jenis penyimpanan session (`file`, `cookie`, `database`, `redis`).
* `SESSION_LIFETIME` – Durasi session (menit).

---

### **Redis & Memcached**

Konfigurasi opsional untuk caching dan session dengan performa lebih tinggi.

```ini
MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

* `REDIS_HOST` – Hostname Redis server.
* `REDIS_PASSWORD` – Password autentikasi Redis (`null` jika tidak digunakan).
* `REDIS_PORT` – Port Redis (default: `6379`).

---

### **Mail Configuration**

Pengaturan untuk pengiriman email keluar.

```ini
MAIL_MAILER=smtp
MAIL_HOST=mail.arahcoffee.co.id
MAIL_PORT=587
MAIL_USERNAME=info@arahcoffee.co.id
MAIL_PASSWORD=********
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@arahcoffee.co.id"
MAIL_FROM_NAME="ARAHCoffee"
```

* `MAIL_MAILER` – Driver mail (`smtp`, `sendmail`, `mailgun`, dll).
* `MAIL_HOST` – Host SMTP server.
* `MAIL_PORT` – Port (`587` untuk TLS, `465` untuk SSL).
* `MAIL_FROM_ADDRESS` – Alamat email default pengirim.
* `MAIL_FROM_NAME` – Nama pengirim yang ditampilkan.

---

### **AWS (Opsional)**

Digunakan jika integrasi dengan Amazon S3 atau layanan AWS lain.

```ini
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

* `AWS_ACCESS_KEY_ID` / `AWS_SECRET_ACCESS_KEY` – Kredensial AWS.
* `AWS_BUCKET` – Nama bucket S3.
* `AWS_DEFAULT_REGION` – Region AWS.

---

### **Pusher (Opsional)**

Konfigurasi untuk fitur real-time menggunakan **Pusher**.

```ini
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

* `PUSHER_APP_KEY` – Public key untuk Pusher.
* `PUSHER_HOST` / `PUSHER_PORT` – Host dan port WebSocket server.
* `VITE_PUSHER_*` – Variabel environment untuk integrasi frontend.

---

### **Octane (Opsional)**

Menentukan engine server Laravel Octane.

```ini
OCTANE_SERVER=frankenphp
```

* `OCTANE_SERVER` – Pilihan: `swoole`, `roadrunner`, `frankenphp`.

---

### **Log Viewer (Opsional)**

Mengaktifkan atau menonaktifkan fitur log viewer di aplikasi.

```ini
LOG_VIEWER_ENABLED=true
```

* `LOG_VIEWER_ENABLED` – `true` untuk mengaktifkan, `false` untuk menonaktifkan.

---

### **Kesimpulan**

File `.env` adalah bagian penting dari keamanan dan stabilitas aplikasi.

* Jangan pernah dipublikasikan atau di-commit ke version control.
* Gunakan **kredensial terpisah** untuk local, staging, dan production.
* Untuk environment production:

  1. Set `APP_ENV=production`
  2. Set `APP_DEBUG=false`
  3. Gunakan password dan API key yang kuat
