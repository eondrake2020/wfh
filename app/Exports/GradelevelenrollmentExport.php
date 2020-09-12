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

class GradelevelenrollmentExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(int $gradelevel_id,$sy_id,$count, float $sum, String $gradelevel, String $datetoday)
    {
        $this->gradelevel_id = $gradelevel_id;
        $this->sy_id = $sy_id;
        $this->count = $count;
        $this->sum = $sum;
        $this->gradelevel = $gradelevel;
        $this->datetoday = $datetoday;
    }

    public function collection()
    {
    	if(Auth::user()->campus_id == NULL){
    		$data = Enrollment::with('student')
        	->select('date','student_id','campus_id','gradelevel_id','strand_id','option_id','amount','isEnrolled')
			->where('sy_id',$this->sy_id)
			->where('gradelevel_id',$this->gradelevel_id)
			->orderBy('campus_id')
			->orderBy('gradelevel_id')
			->get();
    	}else{
    		$data = Enrollment::with('student')
        	->select('date','student_id','campus_id','gradelevel_id','strand_id','option_id','amount','isEnrolled')
			->where('sy_id',$this->sy_id)
			->where('gradelevel_id',$this->gradelevel_id)
			->where('campus_id',Auth::user()->campus_id)
			->orderBy('campus_id')
			->orderBy('gradelevel_id')
			->get();
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
            ['Grade Level',$this->gradelevel],
            ['Report Generated',$this->datetoday],
            [],
            ['Date','LRN','Student Name','Campus','Grade Level','Strand','Tuition Option','Preenrollment Payment','Amount','Status'],
        ];
    }
}
