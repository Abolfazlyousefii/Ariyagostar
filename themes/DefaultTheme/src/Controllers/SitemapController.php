<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    public function index()
    {
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

        // ذخیره سایت‌مپ به صورت فایل
        Storage::disk('public')->put('sitemap.xml', $sitemap->render());

        return response($sitemap->render())->header('Content-Type', 'application/xml');
    }

    public function posts()
    {
        $sitemap = Sitemap::create();

        $posts = Post::published()->latest('updated_at')->get();
        foreach ($posts as $post) {
            $sitemap->add(
                route('front.posts.show', ['post' => $post]),
                $post->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }

        // ذخیره سایت‌مپ به صورت فایل
        Storage::disk('public')->put('sitemap-posts.xml', $sitemap->render());

        return response($sitemap->render())->header('Content-Type', 'application/xml');
    }

    public function pages()
    {
        $sitemap = Sitemap::create();

        $pages = Page::where('published', true)->latest('updated_at')->get();
        foreach ($pages as $page) {
            $sitemap->add(
                route('front.pages.show', ['page' => $page]),
                $page->updated_at->toW3cString(),
                '0.9',
                'weekly'
            );
        }

        // ذخیره سایت‌مپ به صورت فایل
        Storage::disk('public')->put('sitemap-pages.xml', $sitemap->render());

        return response($sitemap->render())->header('Content-Type', 'application/xml');
    }

    public function products()
    {
        $sitemap = Sitemap::create();

        $products = Product::published()->latest('updated_at')->get();
        foreach ($products as $product) {
            $sitemap->add(
                route('front.products.show', ['product' => $product]),
                $product->updated_at->toW3cString(),
                '0.9',
                'daily'
            );
        }

        // ذخیره سایت‌مپ به صورت فایل
        Storage::disk('public')->put('sitemap-products.xml', $sitemap->render());

        return response($sitemap->render())->header('Content-Type', 'application/xml');
    }
}
