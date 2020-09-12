<?php

namespace App\Exports;

use Request;
use App\Preenrollment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PreenrollmentExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    
    public function __construct(int $campus_id,$sy_id,$count,$sum)
    {
        $this->campus_id = $campus_id;
        $this->sy_id = $sy_id;
        $this->count = $count;
        $this->sum = $sum;
    }

    public function collection()
    {
        $data = Preenrollment::whereHas('student', function ($query){
            $query->where('campus_id',$this->campus_id);
        })->select('student_id','amount')->where('sy_id',$this->sy_id)->latest()->get();

        return $data;
    }

    public function map($preenroll): array
    {
        return [
        	$preenroll->student->lrn,
            $preenroll->student->FullName,
            $preenroll->student->campus->name,
            number_format($preenroll->amount,2),
        ];
    }

    public function headings(): array
    {
        return [
        	['Pre Enrollment List',''],
            ['Student Count:',$this->count,'Total Amount',$this->sum],
            [],
            ['LRN','Student Name','Campus','Amount'],
        ];
    }
}
