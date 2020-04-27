<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    // use SearchableTrait;

    protected $table = 'products';

    public function products_lang()
    {
        return $this->hasMany('App\ProductLang');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'product_category', 'product_id', 'category_id');
    }

    public function options()
    {
        return $this->belongsToMany('App\Option', 'product_option', 'product_id', 'option_id');
    }

    public function modes()
    {
        return $this->belongsToMany('App\Mode', 'product_mode', 'product_id', 'mode_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'product_order', 'product_id', 'order_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }
}
