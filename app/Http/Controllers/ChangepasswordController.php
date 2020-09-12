<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;

use Excel;
use Validator;
use Auth;
use PDF;
use DB;
use Session;
use Input;
use Request;
use DateTime;
use Hash;
use Carbon\Carbon;
use DataTables;
use Str;

class ChangepasswordController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function change_password($id){
		$user = User::find($id);
		
		return view('changepassword',compact('user'));
	}

	public function post_change_password($id){
		$user = User::find($id);
		$validator = Validator::make(Request::all(), [
    		'username'					=>	"required|unique:users,name,$user->id,id",
    		'newpassword'				=>	'required',
		],
		[
			'username.required'    		=>	'Username Required',
			'newpassword.required'    	=>	'New Password Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$user->update([
			'name'						=>		Request::get('username'),
			'password'              	=>      \Hash::make(preg_replace('/\s+/', '',Request::get('newpassword'))),
		]);

		toastr()->success('Username and Password Updated Successfully', config('global.system_name'));
	    return redirect()->back();
	}
}
