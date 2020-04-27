<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;
use App\Role;

class RoleController extends Controller
{
    public function index()
    {
    	$roles = Role::all();

        return view('joystick-admin.roles.index', compact('roles'));
    }

    public function create($lang)
    {
        return view('joystick-admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60|unique:roles',
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        return redirect($request->lang.'/admin/roles')->with('status', 'Запись добавлена!');
    }

    public function edit($lang, $id)
    {
        $role = Role::findOrFail($id);

        return view('joystick-admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        return redirect($lang.'/admin/roles')->with('status', 'Запись обновлена!');
    }

    public function destroy($lang, $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect($lang.'/admin/roles')->with('status', 'Запись удалена!');
    }
}