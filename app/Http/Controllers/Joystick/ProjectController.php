<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;
use App\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_id')->get();

        return view('joystick-admin.projects.index', compact('projects'));
    }

    public function create($lang)
    {
        return view('joystick-admin.projects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:projects',
        ]);

        $project = new project;

        $project->sort_id = ($request->sort_id > 0) ? $request->sort_id : $project->count() + 1;
        $project->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $project->title = $request->title;
        $project->name = $request->name;
        $project->image = $request->image;
        $project->meta_title = $request->meta_title;
        $project->meta_description = $request->meta_description;
        $project->content = $request->content;
        $project->lang = $request->lang;
        $project->status = ($request->status == 'on') ? 1 : 0;
        $project->save();

        return redirect($request->lang.'/admin/projects')->with('status', 'Запись добавлена!');
    }

    public function edit($lang, $id)
    {
        $project = Project::findOrFail($id);

        return view('joystick-admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $lang, $id)
    {    	
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $project = Project::findOrFail($id);
        $project->sort_id = ($request->sort_id > 0) ? $request->sort_id : $project->count() + 1;
        $project->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $project->title = $request->title;
        $project->name = $request->name;
        $project->image = $request->image;
        $project->meta_title = $request->meta_title;
        $project->meta_description = $request->meta_description;
        $project->content = $request->content;
        $project->lang = $request->lang;
        $project->status = ($request->status == 'on') ? 1 : 0;
        $project->save();

        return redirect($lang.'/admin/projects')->with('status', 'Запись обновлена!');
    }

    public function destroy($lang, $id)
    {
        $project = Project::find($id);
        $project->delete();

        return redirect($lang.'/admin/projects')->with('status', 'Запись удалена!');
    }
}
