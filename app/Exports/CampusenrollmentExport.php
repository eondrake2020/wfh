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

class CampusenrollmentExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(int $campus_id,$sy_id,$count, float $sum, String $campus, String $datetoday)
    {
    	$this->campus_id = $campus_id;
        $this->sy_id = $sy_id;
        $this->count = $count;
        $this->sum = $sum;
        $this->campus = $campus;
        $this->datetoday = $datetoday;
    }

    public function collection()
    {
        $data = Enrollment::with('student')->where('campus_id',$this->campus_id)
        	->select('date','student_id','campus_id','gradelevel_id','strand_id','option_id','amount','isEnrolled')
			->where('sy_id',$this->sy_id)
			->where('campus_id',$this->campus_id)
			->latest()->get();

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
            ['Campus',$this->campus],
            ['Report Generated',$this->datetoday],
            [],
            ['Date','LRN','Student Name','Campus','Grade Level','Strand','Tuition Option','Preenrollment Payment','Amount','Status'],
        ];
    }
}
