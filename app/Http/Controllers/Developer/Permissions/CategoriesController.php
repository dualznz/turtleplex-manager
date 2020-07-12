<?php

namespace App\Http\Controllers\Developer\Permissions;

use App\PermissionCategories;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function create()
    {
        return view('developer.permissions.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'order'         => 'required|numeric',
            'name'          => 'required|unique:permission_categories|max:255',
            'description'   => 'required|max:255'
        ]);

        PermissionCategories::create([
            'order'         => $request->order,
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        return redirect()->route('developer-permissions')
            ->with('message', 'New permission category called ' . $request->name . ' added')
            ->with('type', 'success');
    }

    public function edit($id)
    {
        $c = PermissionCategories::find($id);
        if (is_null($c)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find category');
        }

        return view('developer.permissions.categories.edit', [
            'c' => $c
        ]);
    }

    public function update($id, Request $request)
    {
        $c = PermissionCategories::find($id);
        if (is_null($c)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find category');
        }

        $this->validate($request, [
            'order'         => 'required|numeric',
            'name'          => 'required|max:255',
            'description'   => 'required|max:255'
        ]);

        $c->order = $request->order;
        $c->name = $request->name;
        $c->description = $request->description;
        $c->save();

        return redirect()->route('developer-permissions')
            ->with('success', 'Edited permission category called ' . $request->name);
    }

    public function destroy($id)
    {
        $c = PermissionCategories::find($id);
        if (is_null($c)) {
            return redirect()->route('developer-permissions')
                ->with('danger', 'Unable to find category');
        }

        if (Permission::where('category_id', $c->id)->count() > 0) {
            return redirect()->route('developer-permissions-categories-edit', $c->id)
                ->with('danger', 'Unable to delete as there are permissions under this category');
        }

        $c->delete();

        return redirect()->route('developer-permissions')
            ->with('success', 'Deleted permission category');
    }
}
