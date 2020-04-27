<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;

use App\Permission;

class PermissionController extends Controller
{
    public function index()
    {
    	$permissions = Permission::all();

        return view('joystick-admin.permissions.index', compact('permissions'));
    }

    public function create($lang)
    {
        return view('joystick-admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60|unique:permissions',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect($request->lang.'/admin/permissions')->with('status', 'Запись добавлена!');
    }

    public function edit($lang, $id)
    {
        $permission = Permission::findOrFail($id);

        return view('joystick-admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect($lang.'/admin/permissions')->with('status', 'Запись обновлена!');
    }

    public function destroy($lang, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect($lang.'/admin/permissions')->with('status', 'Запись удалена!');
    }
}