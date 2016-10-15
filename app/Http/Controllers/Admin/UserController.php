<?php
namespace omg\Http\Controllers\Admin;


use Illuminate\Http\Request;

use omg\User;
use omg\Http\Requests;
use omg\Http\Controllers\Controller;


class UserController extends Controller
{
    public function __construct()
    {
    	 parent::__construct();
    }

    public function index(Request $request)
    {


    	$users = User::all();
    	

    	
    	return view('admin.users.index', ['users'=> $users ]);
    	



    }
}
