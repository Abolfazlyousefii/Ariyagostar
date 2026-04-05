<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, $page)
    {
        $page = Page::detectLang()->where('slug', $page)->orWhere('id', $page)->firstOrFail();

        if ($this->isBlogPage($page)) {
            return redirect()->route('front.blog.index', $request->query());
        }

        return view('front::pages.show', compact('page'));
    }

    private function isBlogPage(Page $page): bool
    {
        $slug = mb_strtolower(trim($page->slug));
        $title = mb_strtolower(trim($page->title));

        return in_array($slug, ['blog', 'وبلاگ'], true) || in_array($title, ['blog', 'وبلاگ'], true);
    }
}
