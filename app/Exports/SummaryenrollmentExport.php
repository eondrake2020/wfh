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


class SummaryenrollmentExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(int $sy_id, String $date_from, String $date_to, String $datetoday)
    {
    	$this->date_from = $date_from;
        $this->sy_id = $sy_id;
        $this->date_to = $date_to;
        $this->datetoday = $datetoday;
    }

    public function collection()
    {
    	if(Auth::user()->campus_id == NULL){
    		$data = Enrollment::with('student')
	        	->select('date','student_id','campus_id','gradelevel_id','strand_id','option_id','amount','isEnrolled')
	        	->whereDate('date','>=',$this->date_from)
	        	->whereDate('date','<=',$this->date_to)
				->where('sy_id',$this->sy_id)
				->latest()->get();
    	}else{
    		$data = Enrollment::with('student')
	        	->select('date','student_id','campus_id','gradelevel_id','strand_id','option_id','amount','isEnrolled')
	        	->whereDate('date','>=',$this->date_from)
	        	->whereDate('date','<=',$this->date_to)
				->where('sy_id',$this->sy_id)
				->where('campus_id',Auth::user()->campus_id)
				->latest()->get();
    	}

    	return $data;	
        
    }

    public function map($enroll): array
    {
    	if($enroll->strand_id == NULL){
    		$strand = 'N/A';
    	}else{
    		$strand = $enroll->strand->name;
    	}

        if($enroll->isEnrolled == 1){
            $status = 'OFFICIALLY ENROLLED';
        }else{
            $status = 'PENDING STATUS';
        }

        $preenrollment = \App\Preenrollment::where('student_id',$enroll->student_id)
            ->where('sy_id',$this->sy_id)
            ->first();

        if($preenrollment == NULL){
            $pre = 0;
        }else{
            $pre = $preenrollment->amount;
        }

        return [
        	$enroll->date,
        	$enroll->student->lrn,
            $enroll->student->FullName,
            $enroll->campus->name,
            $enroll->gradelevel->name,
            $strand,
            $enroll->option->name,
            number_format($pre,2),
            number_format($enroll->amount,2),
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            ['Holy Child College of Davao','Online Enrollment Report'],
            ['Date From',$this->date_from,'Date To',$this->date_to],
            ['Report Generated',$this->datetoday],
            [],
            ['Date','LRN','Student Name','Campus','Grade Level','Strand','Tuition Option','Preenrollment Payment','Amount','Status'],
        ];
    }
}
