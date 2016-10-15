<?php 
namespace omg\Http\Controllers\Admin;

use Illuminate\Http\Request;

use omg\Module;
use omg\Http\Requests;
use omg\Http\Controllers\Controller;

class ModuleController extends Controller
{
 	public function __construct()
    {
    	 parent::__construct();
    }

    public function index(Request $request)
    {


    	$modules = Module::all();
    	

    	
    	return view('admin.users.index', ['modules'=> $modules ]);
    	



    }
}
