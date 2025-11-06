<?php

namespace App\Http\Controllers;

use App\Service\SitemapService;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $sitemap = new SitemapService();
        $sitemap->generate();

        $filePath = public_path('sitemap.xml');
        if (file_exists($filePath)) {
            return response()->file($filePath, [
                'Content-Type' => 'application/xml',
            ]);
        }

        return response('Sitemap not found', 404);
    }
}
