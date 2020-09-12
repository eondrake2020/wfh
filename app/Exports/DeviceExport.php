<?php

namespace App\Exports;

use App\Enrollment;
use Auth;
use Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DeviceExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(int $campus_id,$sy_id, String $campus, String $datetoday)
    {
    	$this->campus_id = $campus_id;
        $this->sy_id = $sy_id;
        $this->campus = $campus;
        $this->datetoday = $datetoday;
    }

    public function collection()
    {
        if(Auth::user()->campus_id == NULL){
	        $data = Enrollment::with('student')->where('campus_id',$this->campus_id)
	        	->select('date','student_id','campus_id','gradelevel_id','isEnrolled')
				->where('sy_id',$this->sy_id)
				->where('withDevice','YES')
				->latest()->get();
		}else{
			$data = Enrollment::with('student')->where('campus_id',$this->campus_id)
	        	->select('date','student_id','campus_id','gradelevel_id','isEnrolled')
				->where('sy_id',$this->sy_id)
				->where('withDevice','YES')
				->where('campus_id',$this->campus_id)
				->latest()->get();
		}

		return $data;
    }

    public function map($enroll): array
    {

        if($enroll->isEnrolled == 1){
            $status = 'OFFICIALLY ENROLLED';
        }else{
            $status = 'PENDING STATUS';
        }

        return [
        	$enroll->date,
        	$enroll->student->lrn,
            $enroll->student->FullName,
            $enroll->student->email,
            $enroll->student->mobile,
            $enroll->campus->name,
            $enroll->gradelevel->name,
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            ['Holy Child College of Davao','Online Enrollment Report'],
            ['With Device'],
            ['Report Generated',$this->datetoday],
            [],
            ['Date','LRN','Student Name','Email Address','Campus','Grade Level','Enrollment Status'],
        ];
    }
}
