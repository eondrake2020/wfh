<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_group;
use App\Employee_group_member;
use App\Task;
use App\Task_member;
use App\Employee_per_task;

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

class TaskController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
		if (Request::ajax()) {
	        $data = Task::where('admin_id',Auth::user()->employee_id)->latest()->get();
	        return Datatables::of($data)
	        
	        ->editColumn('date', function($data) {
            	return Carbon::parse($data->date)->toFormattedDateString();
            })

            ->editColumn('date_started', function($data) {
            	return Carbon::parse($data->date_started)->toFormattedDateString();
            })

            ->editColumn('date_ended', function($data) {
            	return Carbon::parse($data->date_started)->toFormattedDateString();
            })

            ->editColumn('admin_id', function($data) {
            	return $data->admin->FullName;
            })

            ->editColumn('isClose', function($data) {
            	if($data->isClose == 0){
            		$status = 'OPEN';
            	}else{
            		$status = 'CLOSE';
            	}
            	return $status;
            })

            ->addColumn('action', function($data){
               	$btn = '<center><div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                            <a href="'.action('TaskController@edit',$data->id).'" class="dropdown-item"> Edit Task</a>
                            <a href="'.action('TaskController@delete',$data->id).'" class="dropdown-item"> Delete Task</a>
                            <a href="'.action('TaskController@close_task',$data->id).'" class="dropdown-item"> Close Task</a>
                        </div>
                    </div></center>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }
    	return view('admin.tasks.index');
	}

	public function getCombo(){
		$type_id = Request::get('type_id');
		if($type_id == 'GROUP'){
			$data = Employee_group::orderBy('name')->get()->pluck('name','id');
		}elseif($type_id == 'INDIVIDUAL'){
			$data = Employee::orderBy('lastname')->get()->pluck('FullName','id');
		}

		return $data;
	}

	public function create(){
		$admin = Employee::where('email',Auth::user()->email)->first();
		return view('admin.tasks.create',compact('admin'));
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
		    'date'						=>	'required|date',
		    'task_type'					=>	'required',
		    'task_details'				=>	'required',
		    'date_started'				=>	'required|date',
		    'date_ended'				=>	'required|date',
		    'member_id'					=>	'required|array|min:1',
		],
		[
		    'date.required'     		=>	'Date Required',
		    'task_type.required'     	=>	'Please select task type',
		    'task_details.required'    	=>	'Task Details Required',
		    'date_started.required'		=>	'Start Date Required',
		    'date_ended.required'     	=>	'End Date Required',
		    'member_id.required'		=>	'Please Select Participants',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$task_id = Task::create([
			'date'			=>		Request::get('date'),
			'task_type'		=>		Request::get('task_type'),
			'task_details'	=>		Request::get('task_details'),
			'date_started'	=>		Request::get('date_started'),
			'date_ended'	=>		Request::get('date_ended'),
			'admin_id'		=>		Request::get('admin_id'),
		])->id;

		foreach(Request::get('member_id') as $key => $value){
			if(Request::get('task_type') == 'GROUP'){
				$data = Task_member::updateOrCreate([
					'group_id'		=>	$value,
				],[
					'task_id'		=>	$task_id,
					'employee_id'	=>	NULL,
				]);

				$checkGroup = Employee_group_member::where('employee_group_id',$value)->get();
				
				foreach($checkGroup as $c){
					Employee_per_task::updateOrCreate([
						'employee_id'	=>		$c->employee_id,
						'task_id'		=>		$task_id,
					]);
				}

			}else{
				$data = Task_member::updateOrCreate([
					'employee_id'	=>	$value,
				],[
					'task_id'		=>	$task_id,
					'group_id'		=>	NULL,
				]);

				Employee_per_task::updateOrCreate([
					'employee_id'	=>		$value,
					'task_id'		=>		$task_id,
				]);
			}
		}

		toastr()->success('Task Created Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function edit($id){
		$task = Task::find($id);
		if($task->task_type == 'GROUP'){
			$members = Employee_group::orderBy('name')->get()->pluck('name','id');
		}else{
			$members = Employee::orderBy('lastname')->get()->pluck('FullName','id');
		}

		return view('admin.tasks.edit',compact('task','members'));
	}

	public function update($id){
		$task = Task::find($id);

		$validator = Validator::make(Request::all(), [
		    'date'						=>	'required|date',
		    //'task_type'					=>	'required',
		    'task_details'				=>	'required',
		    'date_started'				=>	'required|date',
		    'date_ended'				=>	'required|date',
		    //'member_id'					=>	'required|array|min:1',
		],
		[
		    'date.required'     		=>	'Date Required',
		    //'task_type.required'     	=>	'Please select task type',
		    'task_details.required'    	=>	'Task Details Required',
		    'date_started.required'		=>	'Start Date Required',
		    'date_ended.required'     	=>	'End Date Required',
		    //'member_id.required'		=>	'Please Select Participants',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$task->update([
			'date'			=>		Request::get('date'),
			'task_details'	=>		Request::get('task_details'),
			'date_started'	=>		Request::get('date_started'),
			'date_ended'	=>		Request::get('date_ended'),
		]);

		if(Request::has('member_id')){
			foreach(Request::get('member_id') as $key => $value){
				if($task->task_type == 'GROUP'){
					$data = Task_member::updateOrCreate([
						'group_id'		=>	$value,
					],[
						'task_id'		=>	$task->id,
						'employee_id'	=>	NULL,
					]);
				}else{
					$data = Task_member::updateOrCreate([
						'employee_id'	=>	$value,
					],[
						'task_id'		=>	$task->id,
						'group_id'		=>	NULL,
					]);
				}
			}
		}
		
		toastr()->success('Task Updated Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function delete_member($id){
		$task = Task_member::find($id);
		$checkTask = Task::where('id',$task->task_id)->first();

		if($checkTask->task_type == 'INDIVIDUAL'){
			Employee_per_task::where('task_id',$task->task_id)->where('employee_id',$task->employee_id)->delete();
		}else{
			Employee_per_task::where('task_id',$task->task_id)->delete();
		}
		
		$task->delete();

		toastr()->success('Task Member Deleted Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function delete($id){
		$task = Task::find($id);
		$task->members()->delete();

		Employee_per_task::where('task_id',$task->id)->delete();

		$task->delete();
		toastr()->success('Task Deleted Successfully', config('global.system_name'));
    	return redirect()->back();
	}

	public function close_task($id){
		$task = Task::find($id);
		$task->update([
			'isClose'		=>		1,
		]);

		toastr()->success('Task Closed Successfully', config('global.system_name'));
    	return redirect()->back();
	}	
}
