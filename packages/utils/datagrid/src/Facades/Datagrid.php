<?php namespace OMG\Datagrid\Facades;

use Illuminate\Support\Facades\Facade;

class Datagrid extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'datagrid';
    }


}