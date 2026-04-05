<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function show(Request $request, $page)
    {
        $page = Page::detectLang()->where('slug', $page)->orWhere('id', $page)->firstOrFail();

        if ($this->isBlogPage($page)) {
            $validated = $request->validate([
                'q' => ['nullable', 'string', 'max:120'],
                'category' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'postcat')],
            ]);

            $searchTerm = trim($validated['q'] ?? '');
            $activeCategoryId = $validated['category'] ?? null;

            $postsQuery = Post::detectLang()
                ->published()
                ->with('category')
                ->when($searchTerm !== '', function ($query) use ($searchTerm) {
                    $query->where(function ($innerQuery) use ($searchTerm) {
                        $innerQuery
                            ->where('title', 'like', '%' . $searchTerm . '%')
                            ->orWhere('short_description', 'like', '%' . $searchTerm . '%')
                            ->orWhere('content', 'like', '%' . $searchTerm . '%');
                    });
                })
                ->when($activeCategoryId !== null, function ($query) use ($activeCategoryId) {
                    $query->where('category_id', $activeCategoryId);
                })
                ->latest();

            $posts = $postsQuery->paginate(9)->withQueryString();

            $categories = Category::detectLang()
                ->where('type', 'postcat')
                ->published()
                ->orderBy('ordering')
                ->get();

            $featuredPost = (clone $postsQuery)->first();
            $blogBaseUrl = route('front.pages.show', ['page' => $page]);

            return view('front::posts.index', compact('posts', 'categories', 'activeCategoryId', 'searchTerm', 'featuredPost', 'blogBaseUrl', 'page'));
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
