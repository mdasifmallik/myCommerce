<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter_subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = ['email'];
}
