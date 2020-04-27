<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;

use App\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('sort_id')->get();

        return view('joystick-admin.languages.index', compact('languages'));
    }

    public function create($lang)
    {
        return view('joystick-admin.languages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:80|unique:languages',
        ]);

        $language = new Language;

        $language->sort_id = ($request->sort_id > 0) ? $request->sort_id : $language->count() + 1;
        $language->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $language->title = $request->title;
        $language->save();

        return redirect($request->lang.'/admin/languages')->with('status', 'Запись добавлена!');
    }

    public function edit($lang, $id)
    {
        $language = Language::findOrFail($id);

        return view('joystick-admin.languages.edit', compact('language'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:80',
        ]);

        $language = Language::findOrFail($id);
        $language->sort_id = ($request->sort_id > 0) ? $request->sort_id : $language->count() + 1;
        $language->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $language->title = $request->title;
        $language->save();

        return redirect($lang.'/admin/languages')->with('status', 'Запись обновлена!');
    }

    public function destroy($lang, $id)
    {
        $language = Language::find($id);
        $language->delete();

        return redirect($lang.'/admin/languages')->with('status', 'Запись удалена!');
    }
}
