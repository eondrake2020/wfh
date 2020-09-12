<?php

namespace App\Http\Controllers;

use App\Employee;
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
use Str;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class DtrController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}
}
