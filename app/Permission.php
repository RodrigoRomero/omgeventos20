<?php

namespace omg;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function group()
    {
        return $this->belongsTo('omg\Group');
    }
}
