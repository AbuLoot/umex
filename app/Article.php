<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    public function getDateAttribute()
    {
    	return strtr(date("j F Y ", strtotime($this->created_at)), trans('data.month'));
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'parent');
    }
}
