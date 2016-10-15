<?php

namespace omg;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    
}
