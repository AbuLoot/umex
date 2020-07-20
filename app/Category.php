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
        return $this->hasManyThrough('App\Product', 'App\Product');
    }

    public function products_ext()
    {
        return $this->belongsToMany('App\ProductExt', 'product_category');
    }
}
