<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Link::class, 'link');
    }

    public function index()
    {
        $groups = config('front.linkGroups', []);
        $links  = Link::detectLang()->orderBy('ordering')->get();

        return view('back.links.index', compact('groups', 'links'));
    }

    public function create()
    {
        $groups = config('front.linkGroups', []);

        return view('back.links.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required',
            'link'          => 'required',
            'link_group_id' => 'required',
        ]);

        Link::create([
            'title'            => $request->title,
            'link'             => $request->link,
            'link_group_id'    => $request->link_group_id,
            'lang'             => app()->getLocale(),
            'ordering'         => Link::max('ordering') + 1,
        ]);

        toastr()->success('لینک با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Link $link)
    {
        $groups = config('front.linkGroups', []);

        return view('back.links.edit', compact('link', 'groups'));
    }

    public function update(Link $link, Request $request)
    {
        $this->validate($request, [
            'title'         => 'required',
            'link'          => 'required',
            'link_group_id' => 'required',
        ]);

        $link->update([
            'title'            => $request->title,
            'link'             => $request->link,
            'link_group_id'    => $request->link_group_id,
        ]);

        toastr()->success('لینک با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Link $link)
    {
        if ($link->image) {
            Storage::disk('public')->delete($link->image);
        }

        $link->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('links.update');

        $this->validate($request, [
            'links' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->links as $link) {
            Link::findOrFail($link)->update([
                'ordering' => $i++,
            ]);
        };

        return response('success');
    }

    // groups methods

    public function groups()
    {
        $this->authorize('links.groups');

        $groups = config('front.linkGroups', []);

        return view('back.links.groups', compact('groups'));
    }

    public function updateGroups(Request $request)
    {
        $this->authorize('links.groups');

        $request->validate([
            'groups' => 'required|array',
        ]);

        foreach ($request->groups as $key => $value) {
            option_update('link_groups_' . $key, $value);
        }

        return response('success');
    }
}
