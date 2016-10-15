<?php

namespace omg\Http\Controllers\Admin;

use Illuminate\Http\Request;

use omg\Http\Requests;
use omg\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
    	 parent::__construct();
    }

    public function index()
    {

    	return view('admin.dashboard.index', array('title'=>'asdasdasdadsad'));
    }
}