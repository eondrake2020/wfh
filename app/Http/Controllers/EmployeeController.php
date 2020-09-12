<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Employee;
use App\User;
use App\Imports\EmployeeImport;

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
use Str;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

    public function index(){
		if (Request::ajax()) {
       		$data = \App\Employee::with('campus')->orderBy('lastname')->get();
	        return Datatables::of($data)

	        ->editColumn('lastname', function($data) {
            	return $data->FullName;
            })

            ->addColumn('action', function($data){
            	if($data->category == 'ADMIN'){
            		$btn = '<center><div class="btn-group" role="group">
	                    <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
	                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
	                    	<a href="'.action('EmployeeController@setAdmin',$data->id).'" class="dropdown-item"> Set As Member</a>
	                    	<a href="'.action('EmployeeController@reset',$data->id).'" class="dropdown-item"> Reset Password</a>
	                    </div>
	                </div></center>';
            	}else{
            		$btn = '<center><div class="btn-group" role="group">
	                    <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
	                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
	                    	<a href="'.action('EmployeeController@setAdmin',$data->id).'" class="dropdown-item"> Set As Admin</a>
	                    	<a href="'.action('EmployeeController@reset',$data->id).'" class="dropdown-item"> Reset Password</a>
	                    </div>
	                </div></center>';
            	}
				

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }

	    return view('admin.employees.index');
    }

    public function create(){
    	$campuses = Campus::orderBy('name')->get()->pluck('name','id');
    	return view('admin.employees.create',compact('campuses'));
    }
    public function store(){
    	$validator = Validator::make(Request::all(), [
		    'employee_number'			=>	'required|unique:employees',
		    'lastname'					=>	'required',
		    'firstname'					=>	'required',
		    'email'						=>	'required|unique:employees',
		    'birthdate'					=>	'required|date',
		    'campus_id'					=>	'required',
		    'mobile'					=>	'required',
		    'status'					=>	'required',
		    'category'					=>	'required',
		],
		[
		    'employee_number.required'  =>	'Employee Number Required',
		    'lastname.required'     	=>	'Lastname Required',
		    'firstname.required'     	=>	'Firstname Required',
		    'email.required'     		=>	'Email Required',
			'birthdate.required'     	=>	'Birthdate Required',
		    'campus_id.required'     	=>	'Please select Campus',
			'status.required'     		=>	'Please select Status',
			'category.required'     	=>	'Please select Category',
		    'mobile.required'			=>	'Contact Number Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$file = Request::file('image');
		if($file != NULL){
			$image = Str::random(40).'.'.$file->extension();  
			$file->move(public_path('/images'), $image);
		}else{
			if(Request::get('gender') == 0){
				$image = 'male.png';
			}else{
				$image = 'female.png';
			}
		}

		$employee_id = Employee::create([
			//'employee_number'	=>		Request::get('employee_number'),
			'lastname'			=>		Request::get('lastname'),
			'firstname'			=>		Request::get('firstname'),
			'middlename'		=>		Request::get('middlename'),
			'extname'			=>		Request::get('extname'),
			'gender'			=>		Request::get('gender'),
			'email'				=>		Request::get('email'),
			'birthdate'			=>		Request::get('birthdate'),
			'campus_id'			=>		Request::get('campus_id'),
			'status'			=>		Request::get('status'),
			'category'			=>		Request::get('category'),
			'image'				=>		$image,
			'mobile'			=>		Request::get('mobile'),
			'designation'		=>		Request::get('designation'),
		])->id;

		User::create([
			'employee_id'			=>		$employee_id,
			'name'				=>		Request::get('email'),
			'email'				=>		Request::get('email'),
			'role'				=>		Request::get('category'),
			'password'			=>		\Hash::make(preg_replace('/\s+/', '',strtolower(Request::get('lastname')))),
		]);

		toastr()->success('Employee Created Successfully', config('global.system_name'));
	    return redirect()->back();
		
    }

    public function import(){
    	$validator = Validator::make(Request::all(), [
		    'file'						=>	'required|mimes:xlsx,xls',
		],
		[
		    'file.required'     		=>	'Please select valid file',
		]);

		if ($validator->fails()) {
		    foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		Excel::import(new EmployeeImport,Request::file('file'));
		toastr()->success('Employee List Imported Successfully', config('global.system_name'));
    	return redirect()->back();
    }

    public function setAdmin($id){
    	$employee = Employee::find($id);
    	if($employee->category == 'ADMIN'){
    		$role = 'MEMBER';
    	}else{
    		$role = 'ADMIN';
    	}

    	$employee->update([
    		'category'		=>		$role,
    	]);

    	$employee->user->update([
    		'role'			=>		$role,
    	]);

    	toastr()->success('Employee Role Updated Successfully', config('global.system_name'));
    	return redirect()->back();
    }

    public function reset($id){
    	$employee = Employee::find($id);
    	\App\User::where('employee_id',$employee->id)->update([
			'password'		=>		\Hash::make(preg_replace('/\s+/', '',strtolower($employee->lastname))),
		]);

		toastr()->success('Employee Password Reset Successfully', config('global.system_name'));
    	return redirect()->back();
    }

    public function view_schedule($id){
    	$employee = Employee::where('id',Auth::user()->employee_id)->first();
    	$weekdays = \App\Weekday::pluck('name','id');
    	return view('admin.employees.schedule',compact('employee','weekdays'));
    }

    public function post_schedule($id){
    	$employee = Employee::where('id',Auth::user()->employee_id)->first();
    	$validator = Validator::make(Request::all(), [
		    'weekday_id'					=>	'required|array|min:3',
		],
		[
		    'weekday_id.required'     		=>	'Please select day(s)',
		]);

		if ($validator->fails()) {
		    foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		foreach(Request::get('weekday_id') as $key => $value){
			\App\Employee_schedule::create([
				'employee_id'		=>		$employee->id,
				'weekday_id'		=>		$value,
			]);
		}

		toastr()->success('Employee Schedule Created Successfully', config('global.system_name'));
    	return redirect()->back();
    }
}