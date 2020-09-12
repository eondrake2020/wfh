<?php

namespace App\Exports;

use App\Studentlist;
use Auth;
use Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(String $campus_id)
    {
    	$this->campus_id = $campus_id;
    }

    public function collection()
    {
        if(Auth::user()->campus_id == NULL){
			$data = Studentlist::orderBy('lastname')->get();
		}else{
			$data = Studentlist::where('campus_id',$this->campus_id)->orderBy('lastname')->orderBy('gradelevel_id')->get();
		}

		return $data;
    }

    public function map($list): array
    {
    	if($list->lrn == NULL){
    		$password = preg_replace('/\s+/', '',strtolower($list->lastname));
    	}else{
    		$password = $list->lrn;
    	}
        return [
        	$list->lrn,
        	$list->lastname,
            $list->firstname,
            $list->middlename,
            $list->gradelevel->name,
            $list->campus->name,
            $list->user->name,
            $password,
        ];
    }

    public function headings(): array
    {
        return [
            ['LRN','Last Name','First Name','Middle Name','Grade Level','Campus','Username','Password'],
        ];
    }
}
