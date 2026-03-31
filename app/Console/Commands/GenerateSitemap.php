<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Illuminate\Support\Carbon;
use App\Models\Post;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap files';

    public function handle()
    {
        // سایت‌مپ اصلی با تمام URLها
        $sitemap = Sitemap::create();

        // اضافه کردن صفحات اصلی
        $now = Carbon::now()->toW3cString();
        $sitemap->add(url('/'), $now, '1.0', 'daily');
        $sitemap->add(url('/contact'), $now, '0.8', 'monthly');

        // اضافه کردن پست‌ها
        $posts = Post::published()->latest('updated_at')->get();
        foreach ($posts as $post) {
            $sitemap->add(
                route('front.posts.show', ['post' => $post]),
                $post->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }

        // اضافه کردن صفحات
        $pages = Page::where('published', true)->latest('updated_at')->get();
        foreach ($pages as $page) {
            $sitemap->add(
                route('front.pages.show', ['page' => $page]),
                $page->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }

        // اضافه کردن محصولات
        $products = Product::published()->latest('updated_at')->get();
        foreach ($products as $product) {
            $sitemap->add(
                route('front.products.show', ['product' => $product]),
                $product->updated_at->toW3cString(),
                '0.9',
                'daily'
            );
        }

        // ذخیره سایت‌مپ اصلی
        Storage::disk('public')->put('sitemap.xml', $sitemap->render());

        // سایت‌مپ پست‌ها
        $postsSitemap = Sitemap::create();
        foreach ($posts as $post) {
            $postsSitemap->add(
                route('front.posts.show', ['post' => $post]),
                $post->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }
        Storage::disk('public')->put('sitemap-posts.xml', $postsSitemap->render());

        // سایت‌مپ صفحات
        $pagesSitemap = Sitemap::create();
        foreach ($pages as $page) {
            $pagesSitemap->add(
                route('front.pages.show', ['page' => $page]),
                $page->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }
        Storage::disk('public')->put('sitemap-pages.xml', $pagesSitemap->render());

        // سایت‌مپ محصولات
        $productsSitemap = Sitemap::create();
        foreach ($products as $product) {
            $productsSitemap->add(
                route('front.products.show', ['product' => $product]),
                $product->updated_at->toW3cString(),
                '0.9',
                'daily'
            );
        }
        Storage::disk('public')->put('sitemap-products.xml', $productsSitemap->render());

        $this->info('Sitemap files generated successfully!');
    }
}
