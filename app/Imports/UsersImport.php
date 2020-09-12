<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;


class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $password = \Hash::make(preg_replace('/\s+/', '',strtolower($row[7])));  

        User::updateOrCreate([
            'student_id'            =>      $row[1],
        ],[
            'id'                    =>      $row[0],
            'name'                  =>      $row[3], 
            'email'                 =>      $row[4],           
            'password'              =>      $password,
            'role'                  =>      $row[6],
        ]);
    }
}
