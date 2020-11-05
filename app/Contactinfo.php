<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactinfo extends Model
{
    use SoftDeletes;

    protected $fillable = ['address', 'email', 'phone', 'map_embedd_link'];
}
