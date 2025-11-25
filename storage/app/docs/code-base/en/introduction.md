## **Introduction**

### **About This Project**

Building a website for a brand like **ARAHCoffee**—which is preparing to transform into an IPO (Initial Public Offering) standard company—means creating a platform that is not only visually appealing, but also meets the requirements of professionalism, transparency, and credibility expected of a public company.

This project is developed with a focus on supporting ARAHCoffee’s journey toward IPO readiness, ensuring the website serves as a robust digital foundation for investor relations, public communications, and brand growth.

---

### **System Requirements**

To ensure smooth operation and maintain high standards of security and performance, make sure your environment includes:

-   **[PHP 8.2 or Greater](https://www.php.net/downloads)** – The core programming language for the application.
-   **[Composer](https://getcomposer.org/download/)** – Dependency manager for PHP.
-   **[Node.js](https://nodejs.org/en/download/)** – Required for frontend dependencies and build tools.

---

### **Installation Guide**

Follow these steps to set up and run the application on your local machine:

| Step                             | Command                                            |
| -------------------------------- | -------------------------------------------------- |
| **Clone the repository**         | `git@github.com:morphling-dev/ipo-arah-coffee.git` |
| **Install PHP dependencies**     | `composer install`                                 |
| **Copy environment file**        | `cp .env.example .env`                             |
| **Generate application key**     | `php artisan key:generate`                         |
| **Run migrations & seed data**   | `php artisan migrate --seed`                       |
| **Install Node.js dependencies** | `npm install` or `yarn install`                    |
| **Run the application**          | `php artisan serve`                                |

Once completed, your application should be running and accessible via **`http://localhost:8000`**.

---

### **Key Dependencies**

#### **Composer (PHP) Dependencies**

This project leverages a modern Laravel stack and trusted third-party packages to ensure reliability, scalability, and maintainability—crucial for a public-facing, IPO-ready brand website.

**Core Laravel & Official Packages:**

-   [Laravel Framework](https://laravel.com/) – The backbone of the project.
-   [Livewire](https://livewire.laravel.com/) – Enables reactive UI without JavaScript.
-   [Laravel Octane](https://laravel.com/docs/12.x/octane) – High-performance server.
-   [Laravel Pulse](https://laravel.com/docs/12.x/pulse) – Application performance monitoring.
-   [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum) – API authentication.
-   [Laravel Tinker](https://laravel.com/docs/12.x/artisan#tinker) – REPL for Laravel.

**Essential Third-Party Packages:**

-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction) – Role-based permissions.
-   [Spatie Laravel Analytics](https://spatie.be/docs/laravel-analytics/v5/introduction) – Google Analytics integration.
-   [Spatie Temporary Directory](https://github.com/spatie/temporary-directory) – Temporary file management.
-   [Nwidart Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction) – Modular architecture.
-   [mhmiton Laravel Modules Livewire](https://github.com/mhmiton/laravel-modules-livewire) – Livewire support for modules.
-   [Barryvdh Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf) – PDF generation.
-   [Dompdf](https://github.com/dompdf/dompdf) – PDF rendering library.
-   [SpartnerNL Laravel Excel](https://laravel-excel.com/) – Excel export/import.
-   [Whitecube PHP Prices](https://github.com/whitecube/php-prices) – Price calculations.
-   [Brick Money](https://github.com/brick/money) – Money and currency handling.
-   [Brick PhoneNumber](https://github.com/brick/phonenumber) – Phone number formatting and validation.
-   [Dasundev Livewire Dropzone](https://github.com/dasundev/livewire-dropzone) – File uploads with Livewire.
-   [Doctrine DBAL](https://www.doctrine-project.org/projects/dbal.html) – Database abstraction layer.
-   [GuzzleHTTP](https://docs.guzzlephp.org/en/stable/) – HTTP client for API requests.
-   [Inertia.js Laravel Adapter](https://inertiajs.com/client-side-setup) – SPA support.
-   [Intervention Image](https://image.intervention.io/) – Image handling and manipulation.
-   [Jenssegers Agent](https://github.com/jenssegers/agent) – User agent detection.
-   [Opcodesio Log Viewer](https://github.com/opcodesio/log-viewer) – Log file viewing.
-   [Stichoza Google Translate PHP](https://github.com/Stichoza/google-translate-php) – Google Translate API.
-   [Stripe PHP](https://github.com/stripe/stripe-php) – Stripe payment integration.

---

#### **Node.js Dependencies**

These tools are used to manage frontend assets and deliver a modern, responsive, and accessible user experience—key for a brand aspiring to IPO standards:

-   [Laravel Mix](https://laravel-mix.com/) – Asset compilation and bundling.
-   [Alpine.js](https://alpinejs.dev/) – Lightweight JavaScript framework.
-   [Axios](https://axios-http.com/docs/intro) – HTTP client for API requests.
-   [Tailwind CSS](https://tailwindcss.com/) – Utility-first CSS framework.
-   [PostCSS](https://postcss.org/) – CSS processing and optimization.
-   [Sass](https://sass-lang.com/) – CSS preprocessor for styling.

---

### **License**

&copy; 2025 **ARAHCoffee**. All Rights Reserved.

This project is proprietary and intended solely for ARAHCoffee’s IPO digital transformation. Redistribution or use without explicit permission is strictly prohibited.
