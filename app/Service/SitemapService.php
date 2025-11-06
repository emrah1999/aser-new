<?php

namespace App\Service;

use App\Blog;
use App\CorporativeLogistic;
use App\InternationalDelivery;
use App\Menu;
use App\Models\Product; // example model
use DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class SitemapService
{
    protected $locales = ['az', 'en', 'ru'];

    protected $publicPath = 'sitemap.xml';

    public function generate()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->addAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            $methods = $route->methods();
            $uri = $route->uri();

            if (!in_array('GET', $methods))
                continue;
            if (strpos($uri, '{') !== false)
                continue;
            if (strpos($uri, 'asercargobackend.ailemiz.az') !== false)
                continue;
            if (strpos($uri, 'api') !== false)
                continue;
            if (strpos($uri, 'azericard') !== false)
                continue;
            if (strpos($uri, 'sitemap') !== false)
                continue;

            foreach ($this->locales as $locale) {
                $this->addUrl($xml, $locale, $uri);
            }
        }

        $newsList = DB::table('news')->where('is_active', 1)->get();
        foreach ($newsList as $news) {
            foreach ($this->locales as $locale) {
                $slug = $news->{'slug'};
                $this->addUrl($xml, $locale, $slug, $news->created_at);
            }
        }

        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            foreach ($this->locales as $locale) {
                $slug = 'slug' . '_' . $locale;
                $uri = $blog->$slug;
                $this->addUrl($xml, $locale, $uri, $blog->created_at);
            }
        }

        $tariffs = InternationalDelivery::orderBy('rank', 'asc')->get();
        foreach ($tariffs as $tariff) {
            foreach ($this->locales as $locale) {
                $slug = 'slug' . '_' . $locale;
                $uri = $tariff->$slug;
                $this->addUrl($xml, $locale, $uri, $tariff->updated_at);
            }
        }

        $logistics = CorporativeLogistic::all();
        foreach ($logistics as $logistic) {
            foreach ($this->locales as $locale) {
                $slug = $logistic->slug ?? $logistic->id;
                $slug = 'slug' . '_' . $locale;
                $uri = $logistic->$slug;
                $this->addUrl($xml, $locale, $uri, $logistic->updated_at);
            }
        }

        $menuIds = [1, 2, 3, 4, 5, 6, 7, 8];
        foreach ($menuIds as $id) {
            $menu = Menu::find($id);
            if (!$menu)
                continue;
            foreach ($this->locales as $locale) {
                $slug = 'slug' . '_' . $locale;
                $uri = $menu->$slug;
                $this->addUrl($xml, $locale, $uri, $menu->updated_at ?? now());
            }
        }
        $filePath = public_path($this->publicPath);
        $xml->asXML($filePath);
    }

    protected function addUrl(&$xml, $locale, $uri, $lastmod = null)
    {
        $uri = trim($uri, '/');
        $loc = $locale == 'az' ? url($uri) : url($locale . '/' . $uri);

        $url = $xml->addChild('url');
        $url->addChild('loc', htmlspecialchars($loc));
        if ($lastmod) {
            $url->addChild('lastmod', date('Y-m-d', strtotime($lastmod)));
        }
        $url->addChild('changefreq', 'weekly');
        $url->addChild('priority', '0.7');

        $locales = $this->locales;
        foreach ($locales as $alt) {
            $altLoc = $alt == 'az' ? url($uri) : url($alt . '/' . $uri);
            $link = $url->addChild('xhtml:link', '', 'http://www.w3.org/1999/xhtml');
            $link->addAttribute('rel', 'alternate');
            $link->addAttribute('hreflang', $alt);
            $link->addAttribute('href', $altLoc);
        }
    }
}
