<?php

namespace omg;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Module extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function users()
    {
        return $this->belongsToMany('omg\User');
    }
}
