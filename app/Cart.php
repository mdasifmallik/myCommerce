<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_quantity'];


    public function product(){
    	return $this->belongsTo('App\Product');
    }
}
