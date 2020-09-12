<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;

use App\User;

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
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
    	if (Request::ajax()) {
	        $data = User::where('role','!=','STUDENT')->latest()->get();
	        return Datatables::of($data)
	        ->editColumn('campus_id', function($data) {
            	if($data->campus_id == NULL){
            		$campus = 'ALL CAMPUS';
            	}else{
            		$campus = $data->campus->name;
            	}

            	return $campus;
            })
            ->addColumn('action', function($data){

                   	$btn = '<center><a href="'.action("UserController@edit",$data->id).'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-edit"></i></a>
                   		<a href="'.action("UserController@reset",$data->id).'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Reset Password"><i class="fa fa-refresh"></i></a>
                   		<a href="'.action("UserController@delete",$data->id).'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash"></i></a>		
                   	</center>';

                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }
	    $campuses = \App\Campus::orderBy('name')->get()->pluck('name','id');
    	return view('admin.users.index',compact('users','campuses'));
	}

	public function store(){
    	$validator = Validator::make(Request::all(), [
		    'name'						=>	'required|unique:users',
		    'email'						=>	'required|unique:users',
		    'campus_id'					=>	'required',
		],
		[
		    'name.required'     		=>	'Username Required',
		    'email.required'     		=>	'Email Required',
		    'campus_id.required'     	=>	'Please Select Campus',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		User::create([
			'name'		=>		Request::get('name'),
			'email'		=>		Request::get('email'),
			'role'		=>		Request::get('role'),
			'campus_id'	=>		Request::get('campus_id'),
			'password'	=>		\Hash::make(preg_replace('/\s+/', '',strtolower(Request::get('name')))),
		]);

		toastr()->success('New User Created Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function edit($id){
		$user = User::find($id);
		$campuses = \App\Campus::orderBy('name')->get()->pluck('name','id');
		return view('admin.users.edit',compact('user','campuses'));
	}

	public function update($id){
		$user = User::find($id);
		$validator = Validator::make(Request::all(), [
		    'name'						=>	"required|unique:users,name,$user->id,id",
		    'email'						=>	"required|unique:users,email,$user->id,id",
		    'campus_id'					=>	'required',
		],
		[
		    'name.required'     		=>	'Username Required',
		    'email.required'     		=>	'Email Required',
		    'campus_id.required'     	=>	'Please Select Campus',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$user->update(Request::all());

		toastr()->success('User Updated Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function reset($id){
		$user = User::find($id);
		$user->update([
			'password'		=>		\Hash::make(preg_replace('/\s+/', '',strtolower($user->name))),
		]);

		toastr()->success('User Password Reset Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function delete($id){
		$user = User::find($id);
		$user->delete();

		toastr()->success('User Deleted Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function backup(){
		Artisan::call('backup:run', [
		    '--only-db' => 1
		]);

		toastr()->success('Back Up Done', config('global.system_name'));
    	return redirect()->back();
	}
}
