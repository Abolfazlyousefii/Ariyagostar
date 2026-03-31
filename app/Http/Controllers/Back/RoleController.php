<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        $roles = Role::latest()->paginate(20);

        return view('back.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::whereNull('permission_id')->where('active', true)->orderBy('ordering')->get();

        return view('back.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permissions'   => 'array',
            'permissions.*' => [
                Rule::exists('permissions', 'id')->where(function ($query) {
                    $query->where('active', true);
                }),
            ],
            'title'        => 'required|unique:roles,title'
        ]);

        $role = Role::create([
            'title'       => $request->title,
            'description' => $request->description
        ]);

        $role->permissions()->attach($request->permissions);

        toastr()->success('مقام با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::whereNull('permission_id')->where('active', true)->orderBy('ordering')->get();

        return view('back.roles.edit', compact('permissions', 'role'));
    }

    public function update(Role $role, Request $request)
    {
        $request->validate([
            'permissions'   => 'array',
            'permissions.*' => [
                Rule::exists('permissions', 'id')->where(function ($query) {
                    $query->where('active', true);
                }),
            ],
            'title'        => [
                'required',
                Rule::unique('roles', 'title')->ignore($role->id),
            ],
        ]);

        $role->update([
            'title'       => $request->title,
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions);

        toastr()->success('مقام با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();

        return response('success');
    }
}
