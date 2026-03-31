<?php

namespace App\Http\Controllers\Back;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
    }

    public $ordering = 1;

    public function index()
    {
        $menus = Menu::detectLang()->whereNull('menu_id')
            ->with('childrenMenus')
            ->orderBy('ordering')
            ->get();

        $categories = Category::detectLang()->orderBy('ordering')->get()->groupBy('type');

        return view('back.menus.index', compact('menus', 'categories'));
    }

    public function show(Menu $menu)
    {
        return response()->json(['menu' => $menu, 'title' => $menu->full_title]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);

        $ordering = Menu::max('ordering') + 1;

        $type = $request->type;

        switch ($type) {
            case 'category': {
                    $this->validate($request, [
                        'category' => 'required|exists:categories,id',
                    ]);

                    $menu = Menu::create([
                        'title'       => $request->category_title,
                        'ordering'    => $ordering,
                        'menuable_id' => $request->category,
                        'type'        => $type,
                        'children'    => $request->children ? true : false,
                        'lang'        => app()->getLocale(),
                    ]);

                    break;
                }
            case 'static': {
                    $this->validate($request, [
                        'title'  => 'required',
                        'static' => 'required',
                    ]);

                    $menu = Menu::create([
                        'ordering'    => $ordering,
                        'title'       => $request->title,
                        'static_type' => $request->static,
                        'type'        => $type,
                        'lang'        => app()->getLocale(),
                    ]);

                    break;
                }
            case 'normal':
            case 'megamenu': {
                    $this->validate($request, [
                        'title' => 'required',
                        'link'  => 'required',
                    ]);

                    $menu = Menu::create([
                        'ordering' => $ordering,
                        'title'    => $request->title,
                        'link'     => $request->link,
                        'type'     => $type,
                        'lang'     => app()->getLocale(),
                    ]);
                    break;
                }
        }

        return response()->json(['menu' => $menu, 'title' => $menu->full_title]);
    }

    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);

        $type = $request->type;

        switch ($type) {
            case 'category': {
                    $this->validate($request, [
                        'category' => 'required|exists:categories,id',
                    ]);

                    $menu->update([
                        'title'       => $request->category_title,
                        'menuable_id' => $request->category,
                        'link' => null,
                        'type' => $type,
                        'children'    => $request->children ? true : false,
                    ]);

                    break;
                }
            case 'static': {
                    $this->validate($request, [
                        'title'  => 'required',
                        'static' => 'required',
                    ]);

                    $menu->update([
                        'title'       => $request->title,
                        'static_type' => $request->static,
                        'type'        => $type,
                    ]);

                    break;
                }
            case 'normal':
            case 'megamenu': {
                    $this->validate($request, [
                        'title' => 'required',
                        'link' => 'required',
                    ]);

                    $menu->update([
                        'title' => $request->title,
                        'link' => $request->link,
                        'menuable_id' => null,
                        'type' => $type,
                    ]);

                    break;
                }
        }

        return response()->json(['menu' => $menu, 'title' => $menu->full_title]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
    }

    public function sort(Request $request)
    {
        $this->authorize('menus.update');

        $this->validate($request, [
            'menus' => 'required|array',
        ]);

        $menus = $request->menus;

        $this->sort_category($menus);

        return 'success';
    }

    private function sort_category($menus, $menu_id = null)
    {
        foreach ($menus as $category) {
            Menu::find($category['id'])->update(['menu_id' => $menu_id, 'ordering' => $this->ordering++]);
            if (array_key_exists('children', $category)) {
                $this->sort_category($category['children'], $category['id']);
            }
        }
    }
}
