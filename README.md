## About This Project

This project is a Laravel Boilerplate developed and maintained by SOC Software House.

## Requirements

-   [PHP 8.2 or greater](https://www.php.net/downloads)
-   [Composer](https://getcomposer.org/download/)
-   [Node.js](https://nodejs.org/en/download)

## Installation

| Step                          | Command                                                           |
| :---------------------------- | :---------------------------------------------------------------- |
| Clone Project                 | `git clone <your-repo-url>`                                       |
| Install Composer Dependencies | `composer install`                                                |
| Copy .env file                | `cp .env.example .env`                                            |
| Generate application key      | `php artisan key:generate`                                        |
| Migrate and Seed              | `php artisan migrate --seed`                                      |
| Run Application               | `php artisan serve`                                               |
| Install Node.js Dependencies  | `npm install`                                                     |
| Build Assets                  | `npm run dev`                                                     |

## Composer Dependencies

This boilerplate leverages several Composer packages. Please refer to their documentation for details.

### Laravel Official

* [Laravel](https://laravel.com/)
* [Livewire](https://livewire.laravel.com/)
* [Sanctum](https://laravel.com/docs/sanctum)
* [Octane](https://laravel.com/docs/octane)
* [Pulse](https://laravel.com/docs/pulse)
* [Tinker](https://laravel.com/docs/tinker)
* [Sail](https://laravel.com/docs/sail)

### Others

* [Spatie - Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
* [Nwidart - Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction)
* [Mhmiton - Laravel Modules Livewire](https://github.com/mhmiton/laravel-modules-livewire)
* [Barryvdh - Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf)
* [DOMPDF - Core PDF Renderer](https://github.com/dompdf/dompdf)
* [SpartnerNL - Laravel Excel](https://laravel-excel.com/)
* [Whitecube - PHP Prices](https://github.com/whitecube/php-prices)
* [Brick - Phone Number](https://github.com/brick/phonenumber)
* [Brick - Money](https://github.com/brick/money)
* [Jenssegers - Agent](https://github.com/jenssegers/agent)
* [Intervention - Image](https://image.intervention.io/)
* [OpcodesIO - Log Viewer](https://github.com/opcodesio/log-viewer)

### Dev Tools

* [Barryvdh - Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
* [PestPHP - Plugin Stressless](https://github.com/pestphp/pest-plugin-stressless)

## Node.js Dependencies

This boilerplate uses several Node.js packages. Please refer to their documentation for more information.

### Build Tools & Core

* [Vite](https://vitejs.dev/)
* [Laravel Vite Plugin](https://github.com/laravel/vite-plugin)
* [PostCSS](https://postcss.org/)
<!-- * [Autoprefixer](https://github.com/postcss/autoprefixer) -->
* [TailwindCSS](https://tailwindcss.com/)
* [Concurrently](https://github.com/open-cli-tools/concurrently)
* [Dotenv](https://github.com/motdotla/dotenv)

### AlpineJS Ecosystem

* [Alpine.js](https://alpinejs.dev/)
* [@alpinejs/collapse](https://www.npmjs.com/package/@alpinejs/collapse)
* [@alpinejs/mask](https://www.npmjs.com/package/@alpinejs/mask)
* [@glhd/alpine-wizard](https://github.com/glhd/alpine-wizard)
* [@ryangjchandler/alpine-clipboard](https://github.com/ryangjchandler/alpine-clipboard)

### UI Components & Plugins

* [Preline UI](https://preline.co/)
* [Boxicons](https://boxicons.com/)
* [Flag Icons](https://github.com/lipis/flag-icon-css)
* [Animate.css](https://animate.style/)
* [Tippy.js](https://atomiks.github.io/tippyjs/)
* [Toastify.js](https://apvarun.github.io/toastify-js/)
* [Toastr](https://codeseven.github.io/toastr/)
* [Shepherd.js (Guided Tours)](https://shepherdjs.dev/)
* [Plyr (Media Player)](https://github.com/sampotts/plyr)
* [Tinycrop](https://github.com/aewebsolutions/tinycrop)
* [GMaps.js](https://hpneo.dev/gmaps/)

### Form Enhancers

* [@yaireo/tagify](https://yaireo.github.io/tagify/)

### Charts, Calendars & Maps

<!-- * [ApexCharts](https://apexcharts.com/) -->
* [Chart.js](https://www.chartjs.org/)
<!-- * [JS Vector Map](https://themustafaomar.com/jsvectormap/) -->
* [FullCalendar](https://fullcalendar.io/)
<!-- * [Vanilla Calendar Pro](https://github.com/vanilla-calendar/vanilla-calendar) -->

### Markdown & Editors

* [CKEditor 5](https://ckeditor.com/docs/ckeditor5/latest/)
* [Marked](https://marked.js.org/)
* [Markdown-it](https://github.com/markdown-it/markdown-it)
* [Turndown (HTML to Markdown)](https://github.com/mixmark-io/turndown)
* [Marked GFM Heading ID](https://github.com/Flet/marked-gfm-heading-id)

### UX & Enhancements

* [AOS (Animate On Scroll)](https://michalsnik.github.io/aos/)
* [Shuffle.js (Filtering/Sorting)](https://vestride.github.io/Shuffle/)
* [SortableJS](https://github.com/SortableJS/Sortable)
* [Shareon (Social Sharing)](https://github.com/NicolasCARPi/shareon)
* [Node Snackbar](https://www.npmjs.com/package/node-snackbar)
* [Colorthief (Image Color Extraction)](https://github.com/lokesh/color-thief)
* [CropperJS](https://github.com/fengyuanchen/cropperjs)

### Dev Utilities

* [Lodash](https://lodash.com/)
* [Highlight.js](https://highlightjs.org/)
* [wnumb (number formatting)](https://refreshless.com/wnumb/)

### Livewire Plugins

* [@wotz/livewire-sortablejs](https://github.com/wotzcode/livewire-sortablejs)

## License

This project is licensed under the [SOC Software House Proprietary License Agreement (MME v1.1)](./LICENSE.md).

Copyright &copy; SOC Software House 2025. All rights reserved.
