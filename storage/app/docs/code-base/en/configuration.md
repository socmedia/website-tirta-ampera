## **Configuration Guide**

This document provides an overview of the environment configuration (`.env`) file for **ARAHCoffee – IPO Website**.
These environment variables define how the application runs, covering database connections, logging, caching, mail services, third-party integrations, and more.

---

### **Application Settings**

General configuration for the application environment and base setup.

```ini
APP_NAME="ARAHCoffee - IPO Website"
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

* `APP_NAME` – The display name of the application.
* `APP_ENV` – The environment (`local`, `staging`, `production`).
* `APP_KEY` – Encryption key used internally (should remain unchanged once set).
* `APP_DEBUG` – Enables detailed error output (`true` for development, `false` for production).
* `APP_URL` – The application’s base URL.

---

### **Logging Configuration**

Specifies how application logs are stored and managed.

```ini
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

* `LOG_CHANNEL` – Default log driver (`stack`, `single`, `daily`).
* `LOG_LEVEL` – Minimum level of messages to log (`debug`, `info`, `warning`, `error`, etc.).

---

### **Database Configuration**

Database connection details for the application.

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arahcoffee_web
DB_USERNAME=root
DB_PASSWORD=
```

* `DB_CONNECTION` – Database driver (`mysql`, `pgsql`, `sqlite`).
* `DB_HOST` – Host address of the database server.
* `DB_PORT` – Port for database access (default: `3306` for MySQL).
* `DB_DATABASE` – The database name.
* `DB_USERNAME` – Database username.
* `DB_PASSWORD` – Database password.

---

### **Caching & Session**

Configuration for caching and session handling.

```ini
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

* `CACHE_DRIVER` – Cache storage option (`file`, `redis`, `database`, `memcached`).
* `QUEUE_CONNECTION` – Queue driver (`sync`, `database`, `redis`).
* `SESSION_DRIVER` – Session storage type (`file`, `cookie`, `database`, `redis`).
* `SESSION_LIFETIME` – Session timeout in minutes.

---

### **Redis & Memcached**

Optional configuration for caching and session performance.

```ini
MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

* `REDIS_HOST` – Redis server hostname.
* `REDIS_PASSWORD` – Authentication password (`null` if not required).
* `REDIS_PORT` – Default port for Redis (`6379`).

---

### **Mail Configuration**

Settings for outbound email delivery.

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

* `MAIL_MAILER` – Mail driver (`smtp`, `sendmail`, `mailgun`, etc.).
* `MAIL_HOST` – SMTP server host.
* `MAIL_PORT` – Port (`587` for TLS, `465` for SSL).
* `MAIL_FROM_ADDRESS` – Default sender email address.
* `MAIL_FROM_NAME` – Sender name shown in emails.

---

### **AWS (Optional)**

Used if integrating Amazon S3 or AWS services.

```ini
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

* `AWS_ACCESS_KEY_ID` / `AWS_SECRET_ACCESS_KEY` – AWS credentials.
* `AWS_BUCKET` – S3 bucket name.
* `AWS_DEFAULT_REGION` – AWS region.

---

### **Pusher (Optional)**

Configuration for real-time features using **Pusher**.

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

* `PUSHER_APP_KEY` – Public key for Pusher.
* `PUSHER_HOST` / `PUSHER_PORT` – WebSocket server host and port.
* `VITE_PUSHER_*` – Environment variables for frontend integration.

---

### **Octane (Optional)**

Specifies the Laravel Octane server engine.

```ini
OCTANE_SERVER=frankenphp
```

* `OCTANE_SERVER` – Options: `swoole`, `roadrunner`, `frankenphp`.

---

### **Log Viewer (Optional)**

Enable or disable the in-app log viewer.

```ini
LOG_VIEWER_ENABLED=true
```

* `LOG_VIEWER_ENABLED` – `true` to enable, `false` to disable.

---

### **Conclusion**

The `.env` file is critical to the security and stability of the application.

* Never expose it publicly or commit it to version control.
* Use **separate credentials** for local, staging, and production environments.
* For production:

  1. Set `APP_ENV=production`
  2. Set `APP_DEBUG=false`
  3. Use strong passwords and API keys.
