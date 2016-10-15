<?php

namespace omg;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function permission()
    {
        return $this->hasOne('omg\Permision');
    }

 	public function users()
    {
        return $this->belongsToMany('omg\User');
    }
}
