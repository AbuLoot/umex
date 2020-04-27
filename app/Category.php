<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $table = 'categories';

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_category');
    }

    public function products_lang()
    {
        return $this->hasManyThrough('App\ProductLang', 'App\Product');
    }
}
