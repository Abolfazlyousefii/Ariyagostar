<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckCreator');
    }

    public function index()
    {
        $permissions = Permission::whereNull('permission_id')->orderBy('ordering')->get();

        return view('back.permissions.index', compact('permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'permission'   => 'required|array',
            'permission.*' => 'exists:permissions,id'
        ]);

        Permission::query()->update([
            'active' => false,
        ]);

        foreach ($request->permission as $permission) {

            Permission::find($permission)->update([
                'active' => true,
            ]);
        }
    }
}
