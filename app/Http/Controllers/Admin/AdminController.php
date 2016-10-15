<?php

namespace omg\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use omg\Http\Requests;
use omg\Http\Controllers\Controller;
use omg\Module;

class AdminController extends Controller
{
    var $menu;

	public function __construct(){
		parent::__construct(); 

		
    }



    public function show(){
    	$modules = Module::orderBy('order')->get();
		
		
   		return $this->menu = view('admin.layout.mainmenu', ['modules' => $modules] );

    }
}
