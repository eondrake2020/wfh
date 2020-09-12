<?php

namespace App\Http\Controllers;

use App\Employee_login;

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

class ReportController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}

	public function view_attendance_report(){
		return view('admin.reports.attendance');
	}

	public function print_attendance_report(){
		$validator = Validator::make(Request::all(), [
		    'date_from'				=>	'required|date',
		    'date_to'				=>	'required|date|after_or_equal:date_from',
		],
		[
		    'date_from.required'    =>	'Date From Required',
		    'date_to.required'     	=>	'Date To Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$date_from = Request::get('date_from');
		$date_to = Request::get('date_to');

		$employees = \App\Employee::orderBy('lastname')->get();

		return view('admin.pdf.attendance',compact('date_from','date_to','employees'));
	}
}
