<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function category(){
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function product_images(){
        return $this->hasMany('App\Product_image')->withTrashed();
    }
}
