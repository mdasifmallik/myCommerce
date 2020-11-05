<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
    protected $fillable = ['category_name', 'category_description', 'category_photo'];


    public function products(){
        return $this->hasMany('App\Product');
    }

    public function blog_posts(){
        return $this->hasMany('App\Blog');
    }
}
