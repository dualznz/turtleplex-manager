<?php

namespace App\Http\Controllers\Developer\Permissions;

use App\PermissionCategories;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{

    public function index()
    {
        return view('developer.permissions.index', [
            'roles'         => Role::all(),
            'categories'    => PermissionCategories::orderBy('order', 'ASC')->get(),
            'permissions'   => Permission::all()
        ]);
    }

    public function create()
    {
        return view('developer.permissions.permissions.create', [
            'categories' => PermissionCategories::orderBy('order', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|unique:permissions|max:255',
            'description'   => 'required|max:255',
            'category'      => 'required',
            'add_new_row'   => ''
        ]);

        Permission::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'category_id'   => $request->category == 'none' ? NULL : $request->category
        ]);

        Cache::flush();

        if ($request->add_new_row == true) {
            // redirect back to new permission view
            return view('developer.permissions.permissions.create', [
                'categories' => PermissionCategories::orderBy('order', 'ASC')->get(),
            ]);
        } else {
            // redirect back to permissions overview
            return redirect()->route('developer-permissions')
                ->with('success', 'Created new permission called ' . $request->name);
        }
    }

    public function edit($id)
    {
        $p = Permission::find($id);
        if (is_null($p)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find permission');
        }

        return view('developer.permissions.permissions.edit', [
            'p'             => $p,
            'categories'    => PermissionCategories::orderBy('order', 'ASC')->get(),
        ]);
    }

    public function update($id, Request $request)
    {
        $p = Permission::find($id);
        if (is_null($p)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find permission');
        }

        $this->validate($request, [
            'name'          => 'required|max:255',
            'description'   => 'required|max:255',
            'category'      => 'required'
        ]);

        $p->name = $request->name;
        $p->description = $request->description;
        $p->category_id = $request->category == 'none' ? NULL : $request->category;
        $p->save();

        Cache::flush();

        return redirect()->route('developer-permissions')
            ->with('success', 'Edited permission category called ' . $request->name);
    }

    public function destroy($id)
    {
        $p = Permission::find($id);
        if (is_null($p)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find permission');
        }

        if ($p->roles()->count() > 0) {
            return redirect()->route('developer-permissions-permissions-edit', $p->id)
                ->with('danger', 'Unable to delete as there are roles assigned to this permission');
        }

        $p->delete();

        Cache::flush();

        return redirect()->route('developer-permissions')
            ->with('success', 'Deleted permission');
    }
}
