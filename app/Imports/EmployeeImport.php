<?php

namespace App\Imports;

use App\Employee;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class EmployeeImport implements ToModel
{
    public function model(array $row)
    {
        $password = \Hash::make(preg_replace('/\s+/', '',strtolower($row[3]))); 

        User::updateOrCreate([
            'employee_id'           =>      $row[0],
        ],[
            'name'                  =>      $row[1], 
            'email'                 =>      $row[2],           
            'password'              =>      $password,
            'role'                  =>      $row[4],
        ]);
    }

    
}
