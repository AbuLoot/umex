<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;

use Image;
use Storage;
use Validator;

use App\Mode;
use App\Option;
use App\Comment;
use App\Company;
use App\Product;
use App\ProductLang;
use App\Category;
use App\Language;
use App\Currency;
use App\ImageTrait;
use App\Http\Controllers\Joystick\Controller;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::orderBy('updated_at','desc')->paginate(50);
        $categories = Category::get()->toTree();
        $modes = Mode::all();

        return view('joystick-admin.products.index', ['categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));
        $products_lang = ProductLang::search($text)->paginate(50);
        $modes = Mode::all();

        $products_lang->appends([
            'text' => $request->text,
        ]);

        return view('joystick-admin.products.found', compact('text', 'modes', 'products_lang'));
    }

    public function priceForm()
    {
        $categories = Category::get()->toTree();

        return view('joystick-admin.products.price-edit', ['categories' => $categories]);
    }

    public function categoryProducts($lang, $id)
    {
        $categories = Category::get()->toTree();
        $category = Category::find($id);

        if ($category->children && count($category->children) > 0) {
            $ids = $category->children->pluck('id');
        }

        $ids[] = $category->id;

        $products = Product::orderBy('created_at')->whereHas('categories', function ($query) use ($ids) {
                $query->whereIn('category_id', $ids);
            })->paginate(50);

        $modes = Mode::all();

        return view('joystick-admin.products.index', ['category' => $category, 'categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function actionProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        if (is_numeric($request->action)) {
            Product::whereIn('id', $request->products_id)->update(['status' => $request->action]);
        }
        else {
            $mode = Mode::where('slug', $request->action)->first();
            $products = Product::whereIn('id', $request->products_id)->get();

            foreach ($products as $product) {
                $product->modes()->toggle($mode->id);
            }
        }

        return response()->json(['status' => true]);
    }

    public function create($lang)
    {
        $currency = Currency::where('lang', (($lang == 'ru') ? 'kz' : $lang))->first();
        $categories = Category::get()->toTree();
        $companies = Company::orderBy('sort_id')->get();
        $options = Option::orderBy('sort_id')->get();
        $modes = Mode::all();

        return view('joystick-admin.products.create', ['modes' => $modes, 'currency' => $currency, 'categories' => $categories, 'companies' => $companies, 'options' => $options]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:255|unique:products_lang',
            'company_id' => 'required|numeric',
            'barcode' => 'required',
            // 'images' => 'mimes:jpeg,jpg,png,svg,svgs,bmp,gif',
        ]);

        $company = Company::findOrFail($request->company_id);
        $dirName = $company->id.'/'.time();
        $introImage = NULL;
        $images = [];

        Storage::makeDirectory('img/products/'.$dirName);

        if ($request->hasFile('images')) {
            $images = $this->saveImages($request, $dirName);
            $introImage = current($images)['present_image'];
        }

        $product = new Product;
        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->area = $request->area;
        $product->capacity = $request->area_total;
        $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        if ( ! is_null($request->categories_id)) {
            $product->categories()->attach($request->categories_id);
        }

        if ( ! is_null($request->modes_id)) {
            $product->modes()->attach($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->attach($request->options_id);
        }

        $product_lang = new ProductLang;
        $product_lang->product_id = $product->id;
        $product_lang->slug = str_slug($request->title);
        $product_lang->title = $request->title;
        $product_lang->meta_title = $request->meta_title;
        $product_lang->meta_description = $request->meta_description;
        $product_lang->price = $request->price;
        $product_lang->price_total = $request->price_total;
        $product_lang->description = $request->description;
        $product_lang->characteristic = $request->characteristic;
        $product_lang->lang = $request->lang;
        $product_lang->save();

        return redirect($request->lang.'/admin/products')->with('status', 'Товар добавлен!');
    }

    public function edit($lang, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get()->toTree();
        $product_lang = ProductLang::where('product_id', $product->id)->where('lang', $lang)->first();
        $currency = Currency::where('lang', (($lang == 'ru') ? 'kz' : $lang))->first();
        $companies = Company::orderBy('sort_id')->get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        if ($product_lang == NULL) {
            return view('joystick-admin.products.create-lang', ['modes' => $modes, 'product' => $product, 'product_lang' => $product_lang, 'currency' => $currency, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
        }

        return view('joystick-admin.products.edit', ['modes' => $modes, 'product' => $product, 'product_lang' => $product_lang, 'currency' => $currency, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:255',
            'company_id' => 'required|numeric',
            'barcode' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product_lang = ProductLang::where('product_id', $product->id)->where('lang', $lang)->first();

        if ($product_lang == NULL) {
            $product_lang = new ProductLang;
        }

        $dirName = $product->path;
        $images = unserialize($product->images);

        // Adding new images
        if ($request->hasFile('images')) {

            if ( ! file_exists('img/products/'.$product->company_id) OR empty($product->path)) {
                $dirName = $product->category->id.'/'.time();
                Storage::makeDirectory('img/products/'.$dirName);
                $product->path = $dirName;
            }

            $images = $this->uploadImages($request, $dirName, $images, $product);
            $introImage = current($images)['present_image'];
        }

        // Change directory for new category
        if ($product->company_id != $request->company_id AND file_exists('img/products/'.$product->path)) {
            $dirName = $request->company_id.'/'.time();
            Storage::move('img/products/'.$product->path, 'img/products/'.$dirName);
            $product->path = $dirName;
        }

        // Remove images
        if (isset($request->remove_images)) {
            $images = $this->removeImages($request, $images, $product);
            $introImage = (isset($images[0]['present_image'])) ? $images[0]['present_image'] : 'no-image-middle.png';
        }

        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->area = $request->area;
        $product->capacity = $request->area_total;
        if (isset($introImage)) $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        $product->categories()->sync($request->categories_id);

        $product->modes()->sync($request->modes_id);

        $product->options()->sync($request->options_id);

        // Add new options if exist
        // $options_new = collect($request->options_id)->diff($product->options->pluck('id'));
        // $product->options()->attach($request->options_id);

        // // Delete options
        // if (is_null($request->options_id) OR count($request->options_id) < $product->options->count()) {
        //     $options_del = $product->options->except($request->options_id);
        //     $product->options()->detach($options_del);
        // }

        $product_lang->product_id = $product->id;
        $product_lang->slug = str_slug($request->title);
        $product_lang->title = $request->title;
        $product_lang->meta_title = $request->meta_title;
        $product_lang->meta_description = $request->meta_description;
        $product_lang->price = $request->price;
        $product_lang->price_total = $request->price_total;
        $product_lang->description = $request->description;
        $product_lang->characteristic = (isset($request->characteristic)) ? $request->characteristic : '';
        $product_lang->lang = $request->lang;
        $product_lang->save();

        return redirect($lang.'/admin/products')->with('status', 'Товар обновлен!');
    }

    public function saveImages($request, $dirName)
    {
        $order = 1;
        $images = [];

        foreach ($request->file('images') as $key => $image)
        {
            $imageName = 'image-'.$order.'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

            $watermark = Image::make('img/watermark.png');

            // Creating present images
            $this->resizeOptimalImage($image, 520, 400, '/img/products/'.$dirName.'/present-'.$imageName, 90);

            // Storing original images
            // $image->storeAs('/img/products/'.$dirName, $imageName);
            $this->resizeOptimalImage($image, 1200, 800, '/img/products/'.$dirName.'/'.$imageName, 90, $watermark);

            $images[$key]['image'] = $imageName;
            $images[$key]['present_image'] = 'present-'.$imageName;
            $order++;
        }

        return $images;
    }

    public function uploadImages($request, $dirName, $images = [], $product)
    {
        $order = (!empty($images)) ? count($images) : 1;
        $order = time() + 1;

        foreach ($request->file('images') as $key => $image)
        {
            $imageName = 'image-'.$order.'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

            $watermark = Image::make('img/watermark.png');

            // Creating present images
            $this->resizeOptimalImage($image, 520, 400, '/img/products/'.$dirName.'/present-'.$imageName, 90);

            // Storing original images
            $this->resizeOptimalImage($image, 1200, 800, '/img/products/'.$dirName.'/'.$imageName, 90, $watermark);

            if (isset($images[$key])) {

                Storage::delete([
                    'img/products/'.$product->path.'/'.$images[$key]['image'],
                    'img/products/'.$product->path.'/'.$images[$key]['present_image']
                ]);
            }

            $images[$key]['image'] = $imageName;
            $images[$key]['present_image'] = 'present-'.$imageName;
            $order++;
        }

        ksort($images);
        return $images;
    }

    public function removeImages($request, $images = [], $product)
    {
        foreach ($request->remove_images as $kvalue) {

            if (!isset($request->images[$kvalue])) {

                Storage::delete([
                    'img/products/'.$product->path.'/'.$images[$kvalue]['image'],
                    'img/products/'.$product->path.'/'.$images[$kvalue]['present_image']
                ]);

                unset($images[$kvalue]);
            }
        }

        ksort($images);
        return $images;
    }

    public function destroy($lang, $id)
    {
        $product = Product::findOrFail($id);

        if (! empty($product->images)) {

            $images = unserialize($product->images);

            foreach ($images as $image) {

                if ($image['image'] != 'no-image-middle.png') {
                    Storage::delete([
                        'img/products/'.$product->path.'/'.$image['image'],
                        'img/products/'.$product->path.'/'.$image['present_image']
                    ]);
                }
            }

            Storage::deleteDirectory('img/products/'.$product->path);
        }

        foreach ($product->products_lang as $product_lang) {
            $product_lang->delete();
        }

        $product->delete();

        return redirect($lang.'/admin/products');
    }

    public function comments($id)
    {
        $product = Product::findOrFail($id);

        return view('joystick-admin.products.comments', ['product' => $product]);
    }

    public function destroyComment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect($lang.'/admin/products/'.$comment->parent_id.'/comments')->with('status', 'Запись удалена!');
    }
}