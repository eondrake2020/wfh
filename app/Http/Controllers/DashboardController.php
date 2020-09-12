<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use App\Employee_login;
use App\Employee_per_task;
use App\Event;

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

class DashboardController extends Controller
{
	public function __construct(){
	    $this->middleware('auth');
	}

    public function index(){
    	$employee = Employee::where('id',Auth::user()->employee_id)->first();

        if (Request::ajax()) {
            $data = \App\Employee_per_task::where('employee_id',$employee->id)->orderBy('task_id')->get();
            return Datatables::of($data)

            ->addColumn('date', function($data) {
                return Carbon::parse($data->task->date)->toFormattedDateString();
            })

            ->addColumn('task_type', function($data) {
                return $data->task->task_type;
            })

            ->addColumn('status', function($data) {
                $check = \App\Task_reply::where('task_id',$data->task_id)
                    ->where('employee_id',Auth::user()->employee_id)
                    ->where('isApprove',1)
                    ->first();

                if($check != NULL){
                    $approved = 'APPROVED';
                }else{
                    $approved = 'PENDING';
                }
                return $approved;
            })

            ->addColumn('dates', function($data) {
                $date_from =  Carbon::parse($data->task->date_started)->toFormattedDateString();
                $date_to = Carbon::parse($data->task->date_ended)->toFormattedDateString();
                $dates = $date_from.' - '. $date_to;             
                return $dates;
            })

            ->addColumn('created', function($data) {
                return $data->task->admin->FullName;
            })

            ->addColumn('action', function($data){
                if($data->task->isClose == 0){
                    if($data->employee->category == 'ADMIN'){
                        $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <a href="'.action('DashboardController@view_task',$data->task_id).'" class="dropdown-item"> View Task</a>
                                <a href="'.action('DashboardController@view_task_replies',$data->task_id).'" class="dropdown-item"> View Replies</a>
                            </div>
                        </div></center>';
                    }else{
                        $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <a href="'.action('DashboardController@view_task',$data->task_id).'" class="dropdown-item"> View Task</a>
                            </div>
                        </div></center>';
                    }
                }else{
                    $btn = '<center>CLOSED</center>';
                }

                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
        }

        $admintasks = \App\Task::where('admin_id',Auth::user()->employee_id)->where('task_type','INDIVIDUAL')->get();
    	return view('dashboard',compact('employee','admintasks'));
    }

    public function edit_profile($id){
        $employee = Employee::where('id',Auth::user()->employee_id)->first();
        $campuses = \App\Campus::orderBy('name')->get()->pluck('name','id');
        return view('profile',compact('employee','campuses'));
    }

    public function update_profile($id){
        $employee = Employee::where('id',Auth::user()->employee_id)->first();
        $validator = Validator::make(Request::all(), [
            'employee_number'           =>  "required|unique:employees,employee_number,$employee->id,id",
            'lastname'                  =>  'required',
            'firstname'                 =>  'required',
            'email'                     =>  "required|unique:employees,email,$employee->id,id",
            'birthdate'                 =>  'required|date',
            'campus_id'                 =>  'required',
            'mobile'                    =>  'required',
            'status'                    =>  'required',
            'category'                  =>  'required',
        ],
        [
            'employee_number.required'  =>  'Employee Number Required',
            'lastname.required'         =>  'Lastname Required',
            'firstname.required'        =>  'Firstname Required',
            'email.required'            =>  'Email Required',
            'birthdate.required'        =>  'Birthdate Required',
            'campus_id.required'        =>  'Please select Campus',
            'status.required'           =>  'Please select Status',
            'category.required'         =>  'Please select Category',
            'mobile.required'           =>  'Contact Number Required',
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
            $image = $employee->image;
        }

        $employee->update([
            'employee_number'   =>      Request::get('employee_number'),
            'lastname'          =>      Request::get('lastname'),
            'firstname'         =>      Request::get('firstname'),
            'middlename'        =>      Request::get('middlename'),
            'extname'           =>      Request::get('extname'),
            'gender'            =>      Request::get('gender'),
            'email'             =>      Request::get('email'),
            'birthdate'         =>      Request::get('birthdate'),
            'campus_id'         =>      Request::get('campus_id'),
            'status'            =>      Request::get('status'),
            'category'          =>      Request::get('category'),
            'image'             =>      $image,
            'mobile'            =>      Request::get('mobile'),
            'designation'       =>      Request::get('designation'),
        ]);

        toastr()->success('Profile Updated Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function show_events(){
        $events = \App\Event_date::where('event_date',Carbon::now()->toDateString())->orderBy('event_date')->get();
        $employee = Employee::where('id',Auth::user()->employee_id)->first();
        return view('events',compact('events','employee'));
    }

    public function attend_event($id){
        $event_date = \App\Event_date::find($id);
        $employee = Employee::where('id',Auth::user()->employee_id)->first();

        $checkEventLogin = \App\Event_login::where('event_date_id',$event_date->id)
            ->where('employee_id',$employee->id)
            ->first();

        if($checkEventLogin != NULL){
            toastr()->error('You are already logged in to the event', config('global.system_name'));
            return redirect()->back();
        }

        \App\Event_login::create([
            'event_date_id'     =>      $event_date->id,
            'employee_id'       =>      $employee->id,
            'login'             =>      Carbon::now()->toTimeString(),
        ]);

        $checkLogin = \App\Employee_login::where('employee_id',$employee->id)
            ->where('date',$event_date->event_date)
            ->first();

        if($checkLogin != NULL){
            $checkLogin->update([
                'isEvent'       =>      $event_date->event->title,
            ]);
        }else{
            \App\Employee_login::create([
                'date'              =>      $event_date->event_date,
                'employee_id'       =>      $employee->id,
                'login'             =>      Carbon::now()->toTimeString(),
                'isApproved'        =>      1,
                'isEvent'           =>      $event_date->event->title,
            ]);
        }

        toastr()->success('Event Login Created Successfully', config('global.system_name'));
        return redirect()->back();

    }

    public function login(){
    	$employee = Employee::where('id',Auth::user()->employee_id)->first();
    	$checkTimein = Employee_login::where('employee_id',$employee->id)
    		->where('date',Carbon::now()->toDateString())
    		->first();

        $timenow = Carbon::now()->totimeString();

        if($timenow < '07:45:00'){
            toastr()->error('This is not the time to login', config('global.system_name'));
            return redirect()->back();
        }

    	if($checkTimein == NULL){
    		$timein = [
    			'employee_id'		=>		$employee->id,
    			'date'				=>		Carbon::now()->toDateString(),
    			'login'				=>		Carbon::now()->toTimeString(),
    		];
    		Employee_login::create($timein);

    		toastr()->success('Employee Login Created Successfully', config('global.system_name'));
	   		return redirect()->back();
    	}else{
    		toastr()->error('You are already logged in', config('global.system_name'));
	    	return redirect()->back();
    	}

    }

    public function logout(){
    	$employee = Employee::where('id',Auth::user()->employee_id)->first();
    	$checkTimein = Employee_login::where('employee_id',$employee->id)
    		->where('date',Carbon::now()->toDateString())
    		->first();

        $timenow = Carbon::now()->totimeString();

        if($timenow < '16:00:00'){
            toastr()->error('This is not the time to logout', config('global.system_name'));
            return redirect()->back();
        }

    	if($checkTimein == NULL){
    		toastr()->error('Please login first', config('global.system_name'));
	    	return redirect()->back();
    	}elseif ($checkTimein->logout != NULL) {
    		toastr()->error('You are already logged out', config('global.system_name'));
	    	return redirect()->back();
    	}else{
    		$checkTimein->update([
    			'logout'			=>		Carbon::now()->toTimeString(),
    		]);

    		toastr()->success('Employee Logout Created Successfully', config('global.system_name'));
	   		return redirect()->back();
    	}
    }

    public function view_task($id){
        $task = \App\Task::find($id);
        return view('admin.tasks.task',compact('task'));
    }

    public function post_task($id){
        $task = \App\Task::find($id);

        $validator = Validator::make(Request::all(), [
            'task_reply'                      =>  'required',
        ],
        [
            'task_reply.required'             =>  'Task Reply Required',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
                toastr()->warning($error);
            }
            return redirect()->back()
            ->withInput();
        }

        if(Carbon::now()->toDateString() > $task->date_ended){
            toastr()->error('The task is already expired', config('global.system_name'));
            return redirect()->back();
        }

        \App\Task_reply::updateOrCreate([
            'task_id'       =>      $task->id,
            'employee_id'   =>      Auth::user()->employee_id,
        ],[
            'date'          =>      Carbon::now()->toDateString(), 
            'task_reply'    =>      Request::get('task_reply'),
        ]);

        toastr()->success('Task Reply Created Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function view_task_replies($id){
        $task = \App\Task::find($id);
        
        return view('admin.tasks.replies',compact('task'));
    }

    public function view_reply($task_id,$employee_id){
        $task = \App\Task::find($task_id);
        $employee = \App\Employee::find($employee_id);

        $reply = \App\Task_reply::where('task_id',$task->id)->where('employee_id',$employee->id)->first();

        return view('admin.tasks.reply',compact('task','employee','reply'));
    }

    public function post_reply($task_id,$employee_id){
        $task = \App\Task::find($task_id);
        $employee = \App\Employee::find($employee_id);

        if(Request::get('isApprove') == 1){
            $approve = 1;
        }else{
            $approve = 0;
        }

        \App\Task_reply::where('task_id',$task->id)->where('employee_id',$employee->id)->update([
            'isApprove'     =>      $approve,
        ]);

        $this->getDatesFromRange($task->date_started,$task->date_ended,$employee->id);

        toastr()->success('Task Reply Updated Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function getDatesFromRange($start, $end, $emp,$format = 'Y-m-d') {
        $array = array();
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        $sked = [];
        $schedule = \App\Employee_schedule::where('employee_id',$emp)->get();
        foreach($schedule as $s){
            $sked[] = $s->weekday_id;
        }

        foreach($period as $date) { 

            $checkDate = date('N', strtotime($date->format($format)));;
            
            $checkTimeIn = \App\Employee_login::where('employee_id',$emp)->where('date',$date->format($format))->first();
            if($checkTimeIn != NULL){
                $checkTimeIn->update([
                    'isApproved'    =>      1,
                ]);
            }else{
                if(in_array($checkDate, $sked)){
                    \App\Employee_login::updateOrCreate([
                        'employee_id'       =>      $emp,
                        'date'              =>      $date->format($format),
                        'login'             =>      '08:00:00',
                    ],[
                        'logout'            =>      '17:00:00',
                        'isApproved'        =>      1,
                    ]);
                }
            }
        }        
    }

    public function view_schedule($id){
        $employee = Employee::where('id',Auth::user()->employee_id)->first();
        $weekdays = \App\Weekday::pluck('name','id');
        return view('admin.employees.schedule',compact('employee','weekdays'));
    }

    public function post_schedule($id){
        $employee = Employee::where('id',Auth::user()->employee_id)->first();
        $validator = Validator::make(Request::all(), [
            'weekday_id'                    =>  'required|array|min:3',
        ],
        [
            'weekday_id.required'           =>  'Please select day(s)',
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
                'employee_id'       =>      $employee->id,
                'weekday_id'        =>      $value,
            ]);
        }

        toastr()->success('Employee Schedule Created Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function view_dtr_requests($id){
        $employee = Employee::find(Auth::user()->employee_id);
        $requests = \App\Dtr_request::where('admin_id',$employee->id)->orderBy('date','DESC')->get();
        return view('dtr-request',compact('employee','requests'));
    }

    public function dtr_request($id){
        $employee = Employee::find(Auth::user()->employee_id);
        $admins = Employee::where('category','ADMIN')->orderBy('lastname')->get()->pluck('FullName','id');
        return view('dtr',compact('employee','admins'));
    }

    public function post_dtr_request($id){
        $employee = Employee::find(Auth::user()->employee_id);
        $validator = Validator::make(Request::all(), [
            'admin_id'                  =>  'required',
            'inclusiveDates.*'          =>  'required',    
            'request'                   =>  'required',
        ],
        [
            'admin_id.required'             =>  'Please Select Admin',
            'inclusiveDates.*.required'     =>  'Please Select Inclusive Dates',
            'request.required'              =>  'Request Text is Required',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
                toastr()->warning($error);
            }
            return redirect()->back()
            ->withInput();
        }

        $dtr_request_id = \App\Dtr_request::create([
            'date'          =>      Request::get('date'),
            'employee_id'   =>      $employee->id,
            'admin_id'      =>      Request::get('admin_id'),
            'request'       =>      Request::get('request'),
        ])->id;


        $dates = [];
        foreach(Request::get('inclusiveDates') as $key => $value){
            $c = explode(',',$value);
            foreach($c as $cdate){
                \App\Dtr_request_date::create([
                    'dtr_request_id'    =>      $dtr_request_id,
                    'date'              =>      $cdate,
                ]);
            }
        }

        toastr()->success('DTR Request Submitted Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function edit_dtr_request($id){
        $dtr = \App\Dtr_request::find($id);
        return view('edit-dtr',compact('dtr'));
    }

    public function update_dtr_request($id){
        $dtr = \App\Dtr_request::find($id);
        $validator = Validator::make(Request::all(), [
            'dtr_request_id'            =>  'required|array|min:1',    
        ],  
        [
            'dtr_request_id.required'   =>  'Please Select Date to Approve',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
                toastr()->warning($error);
            }
            return redirect()->back()
            ->withInput();
        }

        $dtr->update([
            'isApprove'     =>      1,
        ]);

        foreach(Request::get('dtr_request_id') as $key => $value){
            \App\Employee_login::updateOrCreate([
                'date'              =>      $value,
            ],[
                'employee_id'       =>      $dtr->employee_id,
                'login'             =>      '08:00:00',
                'logout'            =>      '17:00:00',
                'isApproved'        =>      1,
            ]);
        }

        toastr()->success('DTR Request Approved Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function view_violations($id){
        $employee = Employee::find(Auth::user()->employee_id);
        $list = \App\Employee_corrective::where('employee_id',Auth::user()->employee_id)->orderBy('date','DESC')->get();
        return view('violations',compact('list','employee'));
    }

    public function update_violation($id){
        $violation = \App\Employee_corrective::find($id);
        $violation->update(Request::except('action_taken','facts','admin_id'));

        toastr()->success('Employee Corrective Explanation Updated Successfully', config('global.system_name'));
        return redirect()->back();
    }
}
