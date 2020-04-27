<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;
use App\Page;
use App\Article;
use App\ImageTrait;

use Storage;

class ArticleController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $articles = Article::orderBy('sort_id')->paginate(50);

        return view('joystick-admin.articles.index', compact('articles'));
    }

    public function create($lang)
    {
        $pages = Page::orderBy('sort_id')->get()->toTree();

        return view('joystick-admin.articles.create', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:articles',
        ]);

        $article = new Article;

        $article->sort_id = ($request->sort_id > 0) ? $request->sort_id : $article->count() + 1;
        // $article->page_id = $request->page_id;
        $article->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $article->title = $request->title;
        $article->headline = $request->headline;
        $article->video = $request->headline;

        if ($request->hasFile('image')) {

            $imageName = $request->image->getClientOriginalExtension();

            // Creating present images
            $this->resizeImage($request->image, 370, 240, '/img/articles/present-'.$imageName, 100);

            // Storing original images
            $this->resizeImage($request->image, 1024, 768, '/img/articles/'.$imageName, 90);

            $article->image = $imageName;
        }

        $article->meta_title = $request->meta_title;
        $article->meta_description = $request->meta_description;
        $article->content = $request->content;
        $article->lang = $request->lang;
        $article->status = ($request->status == 'on') ? 1 : 0;
        $article->save();

        return redirect($request->lang.'/admin/articles')->with('status', 'Запись добавлена.');
    }

    public function edit($lang, $id)
    {
        $article = Article::findOrFail($id);
        $pages = Page::orderBy('sort_id')->get()->toTree();

        return view('joystick-admin.articles.edit', compact('article', 'pages'));
    }

    public function update(Request $request, $lang, $id)
    {    	
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $article = Article::findOrFail($id);
        $article->sort_id = ($request->sort_id > 0) ? $request->sort_id : $article->count() + 1;
        // $article->page_id = $request->page_id;
        $article->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $article->title = $request->title;
        $article->headline = $request->headline;
        $article->video = $request->video;

        if ($request->hasFile('image')) {

            if ($article->image != NULL AND file_exists('img/articles/'.$article->image)) {
                Storage::delete('img/articles/present-'.$article->image);
                Storage::delete('img/articles/'.$article->image);
            }

            $imageName = $request->image->getClientOriginalName();

            // Creating present images
            $this->resizeImage($request->image, 370, 240, '/img/articles/present-'.$imageName, 100);

            // Storing original images
            $this->resizeImage($request->image, 1024, 768, '/img/articles/'.$imageName, 90);

            $article->image = $imageName;
        }

        $article->meta_title = $request->meta_title;
        $article->meta_description = $request->meta_description;
        $article->content = $request->content;
        $article->lang = $request->lang;
        $article->status = ($request->status == 'on') ? 1 : 0;
        $article->save();

        return redirect($lang.'/admin/articles')->with('status', 'Запись обновлена.');
    }

    public function destroy($lang, $id)
    {
        $article = Article::find($id);

        if (file_exists('img/articles/'.$article->image)) {
            Storage::delete('img/articles/present-'.$article->image);
            Storage::delete('img/articles/'.$article->image);
        }

        $article->delete();

        return redirect($lang.'/admin/articles')->with('status', 'Запись удалена.');
    }
}