<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;

use App\Page;
use App\Mode;
use App\Slide;
use App\Product;
use App\ProductLang;
use App\Section;
use App\Comment;
use App\Company;
use App\Category;
use App\Currency;

class ShopController extends Controller
{
    public function index()
    {
        $page = Page::first();
        $mode_new = Mode::where('slug', 'new')->first();
        $mode_best = Mode::where('slug', 'best')->first();
        $slide_items = Slide::where('status', 1)->take(5)->get();
        $advantages = Section::where('slug', 'advantages')->where('status', 1)->first();

        return view('index', compact('page'));
    }

    public function allCategoryProducts(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        $categories = $category->descendants()->pluck('id');

        // Include the id of category itself
        $categories[] = $category->getKey();

        // Action operations
        $actions = ['default' => 'id', 'low' => 'price', 'expensive' => 'price DESC', 'popular' => 'views DESC'];
        $sort = ($request->session()->has('action')) ? $actions[session('action')] : 'id';

        if ($request->ajax() AND isset($request->action)) {
            $request->session()->put('action', $request->action);
        }

        // Option operations
        if ($request->ajax() AND isset($request->options_id)) {
            $request->session()->put('options', $request->options_id);
            $request->session()->put('category_id', $category->id);
        }

        if ($request->ajax() AND empty($request->action) AND empty($request->options_id) OR session('category_id') != $category->id) {
            $request->session()->forget('options');
        }

        if ($request->session()->has('options')) {

            $options_id = session('options');
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $categories)->orderByRaw($sort)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(24);
        }
        else {
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $categories)->orderByRaw($sort)
                ->paginate(24);
        }

        if ($request->ajax()) {
            return response()->json(view('products-render', ['products' => $products])->render());
        }

        $options = DB::table('products')
            ->join('product_option', 'products.id', '=', 'product_option.product_id')
            ->join('options', 'options.id', '=', 'product_option.option_id')
            ->select('options.id', 'options.slug', 'options.title', 'options.data')
            ->whereIn('category_id', $categories)
            // ->where('products.status', '<>', 0)
            ->distinct()
            ->get();

        $grouped = $options->groupBy('data');

        return view('products')->with(['category' => $category, 'products' => $products, 'grouped' => $grouped]);
    }

    public function categoryProducts(Request $request, $lang, $category_slug, $category_id)
    {
        $category = Category::findOrFail($category_id);

        if ($category->children && count($category->children) > 0) {
            $ids = $category->children->pluck('id');
        }

        $ids[] = $category->id;

        // Action operations
        $actions = ['default' => 'id', 'popular' => 'views DESC', 'new' => 'updated_at DESC', 'high' => 'price DESC', 'low' => 'price'];
        $sort = ($request->session()->has('action')) ? $actions[session('action')] : 'id';

        if ($request->ajax() AND isset($request->action)) {
            $request->session()->put('action', $request->action);
        }

        // Option operations
        if ($request->ajax() AND isset($request->options_id)) {
            $request->session()->put('options', $request->options_id);
            $request->session()->put('category_id', $category->id);
        }

        if ($request->ajax() AND empty($request->action) AND empty($request->options_id) OR session('category_id') != $category->id) {
            $request->session()->forget('options');
        }

        if ($request->session()->has('options')) {

            $options_id = session('options');

            $products = Product::where('status', '<>', 0)->whereIn('category_id', $ids)->orderByRaw($sort)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(15);
        }
        else {
            $products = Product::where('status', '<>', 0)->orderByRaw($sort)
                ->whereHas('categories', function ($query) use ($ids) {
                    $query->whereIn('category_id', $ids);
                })->paginate(15);
        }

        if ($request->ajax()) {
            return response()->json(view('products-render', ['products' => $products])->render());
        }

        // $options = DB::table('products')
        //     ->join('product_option', 'products.id', '=', 'product_option.product_id')
        //     ->join('options', 'options.id', '=', 'product_option.option_id')
        //     ->select('options.id', 'options.slug', 'options.title', 'options.data')
        //     ->whereIn('category_id', $ids)
        //     // ->where('products.status', '<>', 0)
        //     ->distinct()
        //     ->get();

        // $grouped = $options->groupBy('data');

        return view('category')->with(['category' => $category, 'products' => $products]);
    }

    public function subCategoryProducts(Request $request, $category_slug, $subcategory_slug, $category_id)
    {
        $category = Category::findOrFail($category_id);

        if ($category->children && count($category->children) > 0) {
            $ids = $category->children->pluck('id');
        }

        $ids[] = $category->id;

        // Action operations
        $actions = ['default' => 'id', 'popular' => 'views DESC', 'new' => 'updated_at DESC', 'high' => 'price DESC', 'low' => 'price'];
        $sort = ($request->session()->has('action')) ? $actions[session('action')] : 'id';

        if ($request->ajax() AND isset($request->action)) {
            $request->session()->put('action', $request->action);
        }

        // Option operations
        if ($request->ajax() AND isset($request->options_id)) {
            $request->session()->put('options', $request->options_id);
            $request->session()->put('category_id', $category->id);
        }

        if ($request->ajax() AND empty($request->action) AND empty($request->options_id) OR session('category_id') != $category->id) {
            $request->session()->forget('options');
        }

        if ($request->session()->has('options')) {

            $options_id = session('options');
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $ids)->orderByRaw($sort)
                ->whereHas('options', function ($query) use ($options_id) {
                    $query->whereIn('option_id', $options_id);
                })->paginate(24);
        }
        else {
            $products = Product::where('status', '<>', 0)->whereIn('category_id', $ids)->orderByRaw($sort)
                ->paginate(24);
        }

        if ($request->ajax()) {
            return response()->json(view('products-render', ['products' => $products])->render());
        }

        $options = DB::table('products')
            ->join('product_option', 'products.id', '=', 'product_option.product_id')
            ->join('options', 'options.id', '=', 'product_option.option_id')
            ->select('options.id', 'options.slug', 'options.title', 'options.data')
            ->whereIn('category_id', $ids)
            // ->where('products.status', '<>', 0)
            ->distinct()
            ->get();

        $grouped = $options->groupBy('data');

        return view('products')->with(['category' => $category, 'products' => $products, 'grouped' => $grouped]);
    }

    public function brandProducts($company_slug)
    {
        $page = Page::where('slug', 'catalog')->firstOrFail();
        $company = Company::where('slug', $company_slug)->first();

        return view('products')->with(['page' => $page, 'products_title' => $page->title, 'products' => $company->products]);
    }

    public function product($lang, $product_slug)
    {
        $product_lang = ProductLang::where('slug', $product_slug)->firstOrFail();
        $product_lang->views = $product_lang->views + 1;
        $product_lang->save();

        $currency = Currency::where('lang', (($lang == 'ru') ? 'kz' : $lang))->first();
        $products = ProductLang::search($product_lang->title)->where('lang', $lang)->whereNotIn('id', [$product_lang->id])->take(4)->get();

        return view('product')->with(['product_lang' => $product_lang, 'products' => $products, 'currency' => $currency]);
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, [
            'stars' => 'required|integer|between:1,5',
            'comment' => 'required|min:5|max:500',
        ]);


        $url = explode('/', URL::previous());
        $uri = explode('-', end($url));

        if ($request->id == $uri[0]) {
            $comment = new Comment;
            $comment->parent_id = $request->id;
            $comment->parent_type = 'App\Product';
            $comment->name = \Auth::user()->name;
            $comment->email = \Auth::user()->email;
            $comment->comment = $request->comment;
            $comment->stars = (int) $request->stars;
            $comment->save();
        }

        if ($comment) {
            return redirect()->back()->with('status', 'Отзыв добавлен!');
        }
        else {
            return redirect()->back()->with('status', 'Ошибка!');
        }
    }
}
