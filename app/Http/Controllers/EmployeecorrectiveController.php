<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_corrective;
use App\Corrective_level;

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

class EmployeecorrectiveController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
		$list = Employee_corrective::with('employee')->where('admin_id',Auth::user()->employee_id)->get()->sortBy('employee.lastname');
		return view('admin.employee-correctives.index',compact('list'));
	}

	public function create(){
		$admin = Employee::where('id',Auth::user()->employee_id)->first();
		$employees = Employee::orderBy('lastname')->get()->pluck('FullName','id');
		$correctives = Corrective_level::orderBy('name')->get()->pluck('name','id');
		return view('admin.employee-correctives.create',compact('admin','employees','correctives'));
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
		    'employee_id'				=>	'required|array|min:1',
		    'corrective_level_id'		=>	'required',
		    'facts'						=>	'required',
		],
		[
		    'employee_id.required'  		=>	'Please Select at least one employee',
		    'corrective_level_id.required'	=>	'Please Select Corrective Level',
		    'facts.required'     			=>	'Facts Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		foreach(Request::get('employee_id') as $key => $value){
			Employee_corrective::create([
				'date'						=>		Carbon::now()->toDateString(),
				'employee_id'				=>		$value,
				'corrective_level_id'		=>		Request::get('corrective_level_id'),
				'admin_id'					=>		Auth::user()->employee_id,
				'facts'						=>		Request::get('facts'),
			]);
		}

		toastr()->success('Employee Corrective Action Created Successfully', config('global.system_name'));
	    return redirect()->back();
		
	}

	public function view_details($id){
    	$employee = Employee::find($id);
    	$correctives = Corrective_level::orderBy('name')->get()->pluck('name','id');
    	return view('admin.employee-correctives.details',compact('employee','correctives'));
    }

    public function update_details($id){
    	$entry = Employee_corrective::find($id);
    	$entry->update(Request::all());

    	toastr()->success('Employee Corrective Action Updated Successfully', config('global.system_name'));
	    return redirect()->back();
    }

	public function edit($id){
		
	}

	public function update($id){
		
	}

	public function delete($id){
		
	}
}
