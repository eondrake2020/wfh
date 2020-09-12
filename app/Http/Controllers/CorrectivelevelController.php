<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class CorrectivelevelController extends Controller
{
    public function __construct(){
	    $this->middleware('auth');
	}
	
    public function index(){
    	if (Request::ajax()) {
	        $data = Corrective_level::latest()->get();
	        return Datatables::of($data)
            ->addColumn('action', function($data){

                   $btn = '<center><a href="#edit'.$data->id.'" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-edit"></i></a></center>';

                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	    }
	    $correctives = Corrective_level::orderBy('name')->get();
    	return view('admin.correctives.index',compact('correctives'));
    }

    public function store(){
    	$validator = Validator::make(Request::all(), [
		    'name'						=>	'required|unique:corrective_levels',
		],
		[
		    'name.required'     		=>	'Corrective Level Name Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		Corrective_level::create([
			'name'			=>		Request::get('name'),
		]);

		toastr()->success('Corrective Level Created Successfully', config('global.system_name'));
    	return redirect()->back();
    }

    public function update($id){
		$corrective = Corrective_level::find($id);
		$validator = Validator::make(Request::all(), [
		    'name'						=>	"required|unique:corrective_levels,name,$corrective->id,id",
		],
		[
		    'name.required'     		=>	'Corrective Level Name Required',
		]);

		if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
	            toastr()->warning($error);
	        }
	        return redirect()->back()
	       	->withInput();
		}

		$corrective->update([
			'name'			=>		Request::get('name'),
		]);

		toastr()->success('Corrective Level Updated Successfully', config('global.system_name'));
    	return redirect()->back();
    }
}
