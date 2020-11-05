<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['payment_status'];

    public function order_details()
    {
        return $this->hasMany('App\Order_detail');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
