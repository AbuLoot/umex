<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Nicolaslopezj\Searchable\SearchableTrait;

class ProductLang extends Model
{
    use SearchableTrait;

    protected $table = 'products_lang';

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.barcode' => 5,
            'products_lang.title' => 10,
            'products_lang.description' => 10,
            'products_lang.characteristic' => 10,
        ],
        'joins' => [
            'products' => ['products_lang.product_id', 'products.id'],
        ],
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
