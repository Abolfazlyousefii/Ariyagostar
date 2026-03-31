<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page)
    {
        $page = Page::detectLang()->where('slug', $page)->orWhere('id', $page)->firstOrFail();

        return view('front::pages.show', compact('page'));
    }
}
