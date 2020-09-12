<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_group;
use App\Employee_group_member;

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

class GroupController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
		if (Request::ajax()) {
	        $data = Employee_group::latest()->get();
	        return Datatables::of($data)
            ->addColumn('action', function($data){
				$btn = '<center>
						<a href="'.action("GroupController@edit",$data->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
						<a href="'.action("GroupController@delete",$data->id).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
               			</center>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }
    	return view('admin.groups.index');
	}

	public function create(){
		$employees = Employee::orderBy('lastname')->get()->pluck('FullName','id');
		return view('admin.groups.create',compact('employees'));
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
		    'name'						=>	'required|unique:employee_groups',
		    'employee_id'				=>	'required|array|min:1',
		],
		[
		    'name.required'     		=>	'Group Name Required',
		    'employee_id.required'     	=>	'Please select employee',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$employee_group_id = Employee_group::create([
			'name'		=>		Request::get('name'),
		])->id;

		foreach(Request::get('employee_id') as $key =>	$value){
			$members = Employee_group_member::updateOrCreate([
				'employee_id'			=>		$value,
			],[
				'employee_group_id'		=>		$employee_group_id,
				
			]);
		}

		toastr()->success('Employee Group Created Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function edit($id){
		$group = Employee_group::find($id);
		$employees = Employee::orderBy('lastname')->get()->pluck('FullName','id');
		return view('admin.groups.edit',compact('employees','group'));
	}

	public function update($id){
		$group = Employee_group::find($id);
		$validator = Validator::make(Request::all(), [
		    'name'						=>	"required|unique:employee_groups,name,$group->id,id",
		    //'employee_id'				=>	'required|array|min:1',
		],
		[
		    'name.required'     		=>	'Group Name Required',
		    //'employee_id.required'     	=>	'Please select employee',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$group->update(Request::except('employee_id'));
		
		if(Request::has('employee_id')){
			foreach(Request::get('employee_id') as $key =>	$value){
				$members = Employee_group_member::updateOrCreate([
					'employee_id'			=>		$value,
				],[
					'employee_group_id'		=>		$group->id,
					
				]);
			}
		}

		toastr()->success('Employee Group Updated Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function delete_member($id){
		$group = Employee_group_member::find($id);
		$group->delete();
		toastr()->success('Employee Group Member Deleted Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function delete($id){
		$group = Employee_group::find($id);
		$group->members()->delete();
		$group->delete();
		toastr()->success('Employee Group Deleted Successfully', config('global.system_name'));
    	return redirect()->back();
	}
}
