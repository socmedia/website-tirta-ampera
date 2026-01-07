<?php

namespace App\Console\Commands;

use DOMDocument;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Common\Models\Post;
use Modules\Common\Models\Category;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $urls = [];
        $langs = ['id'];

        // Static main/frontpage routes taken from web.php
        $staticRoutes = [
            // Main Pages
            ['route' => 'front.index',              'priority' => '1',   'changefreq' => 'monthly'], // /
            ['route' => 'front.about',              'priority' => '0.9', 'changefreq' => 'monthly'], // /tentang-kami

            // Layanan group
            ['route' => 'front.service.index',                      'priority' => '0.8', 'changefreq' => 'monthly'],    // /layanan
            ['route' => 'front.service.pay-bill',                   'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/bayar-tagihan
            ['route' => 'front.service.new-connection',             'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/pasang-baru
            ['route' => 'front.service.complaint',                  'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/pengaduan-pelanggan
            ['route' => 'front.service.move-meter',                 'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/pindah-meter
            ['route' => 'front.service.replace-stop-valve',         'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/ganti-stop-kran
            ['route' => 'front.service.change-name',                'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/balik-nama
            ['route' => 'front.service.reconnect',                  'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/buka-kembali
            ['route' => 'front.service.temporary-disconnect',       'priority' => '0.7', 'changefreq' => 'monthly'],    // /layanan/tutup-sementara

            // Info pelanggan group
            ['route' => 'front.customer-info.rights-obligations',   'priority' => '0.7', 'changefreq' => 'monthly'],    // /info-pelanggan/hak-dan-kewajiban
            ['route' => 'front.customer-info.prohibitions',         'priority' => '0.7', 'changefreq' => 'monthly'],    // /info-pelanggan/larangan
            ['route' => 'front.customer-info.groups',               'priority' => '0.7', 'changefreq' => 'monthly'],    // /info-pelanggan/golongan
            ['route' => 'front.customer-info.tariff',               'priority' => '0.7', 'changefreq' => 'monthly'],    // /info-pelanggan/tarif
            ['route' => 'front.customer-info.disturbance-info',     'priority' => '0.7', 'changefreq' => 'monthly'],    // /info-pelanggan/info-gangguan

            // Berita/news listing
            ['route' => 'front.news.index',         'priority' => '0.6', 'changefreq' => 'daily'],      // /berita

            // Other static pages
            ['route' => 'front.contact',            'priority' => '0.5', 'changefreq' => 'monthly'],    // /kontak
            ['route' => 'front.terms-conditions',   'priority' => '0.5', 'changefreq' => 'monthly'],    // /syarat-ketentuan
            ['route' => 'front.privacy-policy',     'priority' => '0.5', 'changefreq' => 'monthly'],    // /kebijakan-privasi
        ];

        foreach ($staticRoutes as $routeInfo) {
            if (!\Illuminate\Support\Facades\Route::has($routeInfo['route'])) continue;
            $loc = route($routeInfo['route']);
            $urls[] = [
                'loc'        => $loc . '?lang=' . $langs[0],
                'lastmod'    => Carbon::now()->toAtomString(),
                'priority'   => $routeInfo['priority'],
                'changefreq' => $routeInfo['changefreq'],
                'alternates' => [],
            ];
        }

        // News detail pages
        foreach (Post::published()->get() as $news) {
            $baseUrl = route('front.news.show', $news->slug);
            $urls[] = [
                'loc' => $baseUrl . '?lang=' . $langs[0],
                'lastmod' => optional($news->updated_at)->toAtomString() ?? Carbon::now()->toAtomString(),
                'priority' => '0.4',
                'changefreq' => 'weekly',
                'alternates' => [],
            ];
        }

        // ✅ Build XML using DOMDocument
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urlset->setAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
        $dom->appendChild($urlset);

        foreach ($urls as $url) {
            $urlElement = $dom->createElement('url');

            // <loc>
            $loc = $dom->createElement('loc', htmlspecialchars($url['loc'], ENT_XML1));
            $urlElement->appendChild($loc);

            // <xhtml:link rel="alternate" ... /> -- Not needed, as 'alternates' will always be empty

            // <lastmod>
            $lastmod = $dom->createElement('lastmod', $url['lastmod']);
            $urlElement->appendChild($lastmod);

            // <priority>
            $priority = $dom->createElement('priority', $url['priority']);
            $urlElement->appendChild($priority);

            // <changefreq>
            $changefreq = $dom->createElement('changefreq', $url['changefreq']);
            $urlElement->appendChild($changefreq);

            $urlset->appendChild($urlElement);
        }

        $dom->save(public_path('sitemap.xml'));
    }
}
