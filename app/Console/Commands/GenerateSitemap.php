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
        $langs = ['id', 'en'];

        // Main priority static routes (in order)
        $mainRoutes = [
            '/' => 'index',
            '/about' => 'about',
            '/product' => 'product',
            '/location' => 'location',
            '/collaboration' => 'collaboration',
            '/investor' => 'investor',
        ];

        foreach ($mainRoutes as $uri => $name) {
            $baseUrl = url($uri);
            $urls[] = [
                'loc' => $baseUrl . '?lang=' . $langs[0], // default lang
                'lastmod' => Carbon::now()->toAtomString(),
                'priority' => '1',
                'changefreq' => 'monthly',
                'alternates' => collect($langs)->map(function ($lang) use ($baseUrl) {
                    return [
                        'hreflang' => $lang,
                        'href' => $baseUrl . '?lang=' . $lang,
                    ];
                })->toArray(),
            ];
        }

        // News detail pages
        foreach (Post::published()->with('translations')->get() as $news) {
            foreach ($news->translations as $translation) {
                $baseUrl = route('front.news.show', $translation->slug);

                $urls[] = [
                    'loc' => $baseUrl . '?lang=' . $langs[0],
                    'lastmod' => optional($news->updated_at)->toAtomString() ?? Carbon::now()->toAtomString(),
                    'priority' => '0.5',
                    'changefreq' => 'weekly',
                    'alternates' => collect($langs)->map(function ($lang) use ($baseUrl) {
                        return [
                            'hreflang' => $lang,
                            'href' => $baseUrl . '?lang=' . $lang,
                        ];
                    })->toArray(),
                ];
            }
        }

        // Investor documents categories
        $category = Category::where('group', 'investor_documents')->first();
        if ($category) {
            foreach ($category->translations as $translation) {
                $baseUrl = route('front.investor.documents', $translation->slug);

                $urls[] = [
                    'loc' => $baseUrl . '?lang=' . $langs[0],
                    'lastmod' => optional($category->updated_at)->toAtomString() ?? Carbon::now()->toAtomString(),
                    'priority' => '0.5',
                    'changefreq' => 'weekly',
                    'alternates' => collect($langs)->map(function ($lang) use ($baseUrl) {
                        return [
                            'hreflang' => $lang,
                            'href' => $baseUrl . '?lang=' . $lang,
                        ];
                    })->toArray(),
                ];
            }
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

            // <xhtml:link rel="alternate" ... />
            if (!empty($url['alternates'])) {
                foreach ($url['alternates'] as $alternate) {
                    $link = $dom->createElement('xhtml:link');
                    $link->setAttribute('rel', 'alternate');
                    $link->setAttribute('hreflang', $alternate['hreflang']);
                    $link->setAttribute('href', $alternate['href']);
                    $urlElement->appendChild($link);
                }
            }

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
