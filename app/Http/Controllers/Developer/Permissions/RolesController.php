<?php

namespace App\Http\Controllers\Developer\Permissions;

use App\User;
use App\PermissionCategories;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{

    public function index()
    {
        return view('developer.permissions.index', [
            'roles' => Role::all()
        ]);
    }

    public function create()
    {
        return view('developer.permissions.roles.create', [
            'categories' => PermissionCategories::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles|max:255'
        ]);

        $r = Role::create([
            'name' => $request->name
        ]);

        foreach (Permission::all() as $p) {
            $request->input(str_replace('.', '_', $p->name)) ? ($r->hasPermissionTo($p->name) ? : $r->givePermissionTo($p->name)) : $r->revokePermissionTo($p->name);
        }

        Cache::flush();

        return redirect()->route('developer-permissions')
            ->with('success', 'Create new role called ' . $request->name);
    }

    public function edit($id)
    {
        $r = Role::find($id);
        if (is_null($r)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find role');
        }

        return view('developer.permissions.roles.edit', [
            'r'             => $r,
            'categories'    => PermissionCategories::all(),
        ]);
    }

    public function update($id, Request $request)
    {
        $r = Role::find($id);
        if (is_null($r)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find role');
        }

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        foreach (Permission::all() as $p) {
            $request->input(str_replace('.', '_', $p->name)) ? ($r->hasPermissionTo($p->name) ? : $r->givePermissionTo($p->name)) : $r->revokePermissionTo($p->name);
        }

        $r->name = $request->name;
        $r->save();

        Cache::flush();

        return redirect()->route('developer-permissions-roles-edit', $r->id)
            ->with('success', 'Updated role with new permissions');
    }

    public function destroy($id)
    {
        $r = Role::find($id);
        if (is_null($r)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find role');
        }

        if (User::role($r->name)->count() > 0) {
            return redirect()->route('developer-permissions-roles-edit', $r->id)
                ->with('danger', 'Unable to delete as there are users assigned this role');
        }

        $r->delete();

        Cache::flush();

        return redirect()->route('developer-permissions')
            ->with('danger', 'Deleted role');
    }
}
