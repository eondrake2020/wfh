<?php

namespace App\Http\Controllers;

use App\Event;
use App\Event_date;

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

class EventController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
    	if (Request::ajax()) {
	        $data = Event::latest()->get();
	        return Datatables::of($data)
	        ->editColumn('date', function($data) {
            	return Carbon::parse($data->date)->toFormattedDateString();
            })

            ->editColumn('date_from', function($data) {
            	return Carbon::parse($data->date_from)->toFormattedDateString();
            })

            ->editColumn('date_to', function($data) {
            	return Carbon::parse($data->date_to)->toFormattedDateString();
            })

            ->addColumn('action', function($data){
				$btn = '<center>
					<a href="'.action('EventController@edit',$data->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
					<a href="'.action('EventController@view_event_list',$data->id).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i></a>
					<a href="'.action('EventController@delete',$data->id).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
				</center>';
				return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }
    	return view('admin.events.index');
    }

	public function create(){
		return view('admin.events.create');
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
		    'title'						=>	'required|unique:events',
		    'description'				=>	'required',
		],
		[
		    'title.required'     		=>	'Event Title Required',
		    'description.required'		=>	'Event Description Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$event_id = Event::create(Request::all())->id;

		$this->getDatesFromRange(Request::get('date_from'),Request::get('date_to'),$event_id);

		toastr()->success('Event Created Successfully', config('global.system_name'));
        return redirect()->back();

	}

	public function getDatesFromRange($start, $end, $event, $format = 'Y-m-d') {
        $array = array();
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        foreach($period as $date) { 
        	Event_date::create([
        		'event_id'		=>		$event,
        		'event_date'	=>		$date->format($format),
        	]);
        }        
    }

    public function edit($id){
    	$event = Event::find($id);
    	return view('admin.events.edit',compact('event'));
    }

    public function update($id){
    	$event = Event::find($id);
    	$validator = Validator::make(Request::all(), [
		    'title'						=>	"required|unique:events,title,$event->id,id",
		    'description'				=>	'required',
		],
		[
		    'title.required'     		=>	'Event Title Required',
		    'description.required'		=>	'Event Description Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$event->update(Request::all());
		$event->eventdates()->delete();

		$this->getDatesFromRange($event->date_from,$event->date_to,$event->id);

		toastr()->success('Event Updated Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function delete($id){
    	$event = Event::find($id);
    	$event->eventdates()->delete();
    	$event->delete();

    	toastr()->success('Event Deleted Successfully', config('global.system_name'));
        return redirect()->back();
    }

    public function view_event_list($id){
    	$event = Event::find($id);
    	return view('admin.events.list',compact('event'));
    }

    public function print($id){
    	$eventdate = Event_date::find($id);
    	$logins = \App\Event_login::where('event_date_id',$eventdate->id)->orderBy('login')->get();
    	return view('admin.pdf.seminar-attendance',compact('eventdate','logins'));
    }
}
